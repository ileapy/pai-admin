// pages/play/play.js
//获取应用实例
const app = getApp()
var util= require('../../utils/util.js')
var video = null;
Page({
  data: {
    vid:"",
    video_url:"",
    isGet:false,
    skip_sec:0,
    playTime:0,
    dataSet:{},
    info:{},
    isCollect:false,
    playNum:0,
  },

    onLoad: function (options) {
      if (app.globalData.base.audit == 1) {
        return wx.redirectTo({
          url: '/pages/love/love',
        });
      }
      this.data.vid = options.vid;
      this.data.xid = options.xid;
      this.info(options.vid,options.xid)
      video = wx.createVideoContext('video')
      this.data.skip_sec = 0;
    },

    onUnload:function(e)
    {
      util.request(app.globalData.api_url+"/video/pause","POST",{vid:this.data.vid,xid:this.data.xid,sec:this.data.playTime},true);
    },

    play:function(e)
    {
      // if(!app.globalData.isLogin) wx.reLaunch({
      //   url: '/pages/login/login',
      // })
      if(!app.globalData.isLogin) {
        wx.navigateTo({
          url: '/pages/login/login',
        })
      }else if(!this.data.isGet)
      {
        this.info(this.data.vid,this.data.xid);
      }
    },

    timeChange:function(e)
    {
      this.data.playTime = e.detail.currentTime.toFixed(2)
    },

    pause:function(e)
    {
      if (this.data.vid == undefined) return false;
      util.request(app.globalData.api_url+"/video/pause","POST",{vid:this.data.vid,xid:this.data.xid,sec:this.data.playTime},true);
    },

    itemPlay:function(e)
    {
      this.data.skip_sec = 0;
      this.data.xid = e.currentTarget.dataset.xid;
      this.data.vid = e.currentTarget.dataset.vid;
      this.getUrl(e.currentTarget.dataset.vid,e.currentTarget.dataset.xid);
      this.data.skip_sec = e.currentTarget.dataset.sec != null ? parseFloat(e.currentTarget.dataset.sec) :  this.data.skip_sec;
    },

    getUrl:function(vid,xid="")
    {
      var that = this;
      util.request(app.globalData.api_url+"/video/url","POST",{vid:vid,xid:xid},true).then((res) => {
        if(res.status == 200)
        {
          that.setData({
            video_url:res.data.url,
            curNum:res.data.curNum,
          });
          that.data.xid = xid
          that.data.skip_sec = res.data.skip_sec != "" ? parseFloat(res.data.skip_sec) : that.data.skip_sec;
          video.seek(that.data.skip_sec);
        }else if(res.status == 2001)
        {
          wx.showModal({
            title:"提示信息",
            content:res.msg,
            cancelText:"取消",
            confirmText:"获取",
            success(res){
              if (res.confirm) {
                that.pay();
              }
            }
          });
        }else
        {
          wx.hideLoading()
          wx.showModal({
            title:"获取视频地址失败",
            content:"没有获取到视频数据，请刷新重试。",
            cancelText:"取消",
            confirmText:"刷新",
            success(res){
              if (res.confirm) {
                that.getUrl(vid,xid);
              }
            }
          });
        }
      })
      .catch((res)=>{
        console.log(res);
      })
    },

    pay:function()
    {
      var that = this;
      util.request(app.globalData.api_url+"/order/order","POST",{vid:this.data.vid,xid:this.data.xid},true).then((res)=>{
        if(res.status == 200)
        {
          util.request(app.globalData.api_url+"/order/pay","POSt",{oid:res.data.oid},true).then((res)=>{
            if(res.status == 200)
            {
              wx.requestPayment({
                timeStamp: res.data.data.timeStamp,
                nonceStr:  res.data.data.nonceStr,
                package: res.data.data.package,
                signType: res.data.data.signType,
                paySign: res.data.data.paySign,
                success (res) {
                  that.onLoad({vid:that.data.vid,xid:that.data.xid})
                 },
                fail (res) {
                  wx.showModal({
                    title:"信息提示",
                    content:"支付失败了",
                    cancelText:"取消",
                    confirmText:"确认"
                  });
                 }
              })
            }
          });
        }
      });
    },

    playOver:function(e)
    {
      // 播放完成
      util.request(app.globalData.api_url+"/video/pause","POST",{vid:this.data.vid,xid:this.data.xid,sec:this.data.playTime},true);
      // 播放下一集
      var xid =  this.nextItem();
      if(xid) this.getUrl(this.data.vid,xid);
    },

    nextItem:function()
    {
      if (this.data.dataSet == undefined) return "";
      var lst = [];
      this.data.dataSet.forEach(val => {
        lst.push(val.xid);
      });
      if(lst.length > lst.indexOf(this.data.xid)+1)
      {
        return lst[lst.indexOf(this.data.xid)+1];
      }
      return "";
    },

    info:function(vid,xid="")
    {
      var that = this;
      util.request(app.globalData.api_url+"/video/info","POST",{vid:vid},true).then((res) => {
        console.log(res);
        if(res.status == 200)
        {
          that.setData({
            title:res.data.title,
            tag:res.data.tag,
            actor:res.data.actor,
            desc:res.data.desc,
            list:res.data.list,
            type:res.data.type,
            curNum:res.data.curNum,
            info:res.data,
            isCollect:res.data.isCollect,
            playNum:res.data.playNum,
          });
          that.data.curNum = res.data.curNum;
          that.data.xid =  res.data.curXid;
          that.data.skip_sec = parseFloat(res.data.skip_sec);
          that.data.dataSet = res.data.list
          video.seek(that.data.skip_sec);
          that.data.isGet = true;
          this.data.info = res.data
          wx.setNavigationBarTitle({
            title: res.data.title
          });
          if(res.data.type == "movie") this.getUrl(res.data.vid);
          else if(res.data.type == "tv" && res.data.list.length > 0) this.getUrl(res.data.vid,that.data.xid ? that.data.xid : res.data.list[0]['xid']);
        }else
        {
          wx.hideLoading()
          wx.showModal({
            title:"获取视频地址失败",
            content:"没有获取到视频数据，请刷新重试，点击取消返回上一页面。",
            cancelText:"取消",
            confirmText:"刷新",
            success(res){
              if (res.confirm) {
                that.onLoad({vid:vid,xid:xid});
              } else if (res.cancel) {
                wx.navigateBack({
                  delta: 1,
                })
              }
            }
          });
        }
      })
      .catch((res)=>{
        console.log(res);
      })
    },
    onShareAppMessage:function(options)
    {
      return {
        title: app.globalData.userInfo.nickName +" 邀请您观看《"+ this.data.title+"》",
        imageUrl: this.data.info.image != null && this.data.info.image != "" ? this.data.info.image : "",
        path:"/pages/play/play?vid="+this.data.vid+"&xid="+this.data.xid,
      }
    },
    collect:function()
    {
      var that = this;
      util.request(app.globalData.api_url+"/video/collect","POST",{vid:this.data.vid},true).then((res)=>{
        if(res.status == 200)
        {
          that.data.isCollect = !that.data.isCollect;
          that.setData({
            isCollect:that.data.isCollect,
          });
        }
      })
    }
})
