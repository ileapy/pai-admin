// pages/mine/mine.js

const app = getApp()
var util = require('../../utils/util.js')

Page({
  /**
   * 组件的初始数据
   */
  data: {
    nickname:"未登录",
    avatar:"/utils/images/people.png",
    record:{},
  },

  // 加载页面
  onLoad:function()
  {

  },

  onShow:function()
  {
    if (!app.globalData.isLogin) return wx.navigateTo({
      url: '/pages/login/login',
    });
    this.setData({
      nickname: app.globalData.userInfo.nickName,
      avatar: app.globalData.userInfo.avatarUrl
    });
    this.record();
  },

  toLogin:function()
  {
    if (!app.globalData.isLogin) return wx.navigateTo({
      url: '/pages/login/login',
    });
  },

  /**
   * 观影记录
   */
  record:function()
  {
    var that = this;
    util.request(app.globalData.api_url+"/video/record","POST",{},true).then((res)=>{
      if (res.status == 200)
      {
        that.setData({
          record:res.data
        });
      }
    });
  },

  play(e)
  {
    wx.navigateTo({
      url:"/pages/play/play?vid="+e.currentTarget.dataset.vid
    })
  },

    /**
   * 跳转到收藏
   */
  collect:function()
  {
    wx.reLaunch({
      url: '/pages/collect/collect',
    })
  },
  recordLst:function()
  {
    wx.navigateTo({
      url: '/pages/record/record',
    });
  },
  pay:function()
  {
    wx.navigateTo({
      url: '/pages/pay/pay',
    });
  }
})
