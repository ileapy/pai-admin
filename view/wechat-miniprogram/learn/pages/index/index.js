//index.js
//获取应用实例
const app = getApp()
var util= require('../../utils/util.js')

Page({
  data: {
    banner:{},
    url:app.globalData.url,
    like:{},
    movie:{},
    tv:{}
  },

  onLoad: function () {

  },
  onShow:function()
  {
    this.GetBanner()
    this.GetVideo()
  },
  GetBanner()
  {
    var that = this;
    util.request(app.globalData.api_url+"/index/banner")
    .then(res => {
      // console.log(res.data);
      that.setData({
        banner:res.data
      });
    })
    .catch(res => {
      console.log(res)
    })
  },
  GetVideo()
  {
    var that = this;
    util.request(app.globalData.api_url+"/index/index")
    .then(res => {
      // console.log(res.data);
      that.setData({
        movie:res.data.movie,
        tv:res.data.tv,
        like:res.data.recommend
      });
    })
    .catch(res => {
      console.log(res)
    })
  },
  goto_page(e)
  {
    wx.navigateTo({
      url: e.currentTarget.dataset.link,
    })
  },
  // 播放
  play(e)
  {
    wx.navigateTo({
      url:"/pages/play/play?vid="+e.currentTarget.dataset.vid
    })
  },

  // 去搜索
  search()
  {
    wx.reLaunch({
      url: '/pages/category/category',
    })
  },
  onShareAppMessage()
  {

  }
})
