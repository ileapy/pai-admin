//index.js
//获取应用实例
const app = getApp()
var util= require('../../utils/util.js')

Page({
  data: {
    banner:{},
    url:app.globalData.url,
  },

  onLoad: function () {
    this.GetBanner()
  },
  GetBanner()
  {
    var that = this;
    util.request(app.globalData.api_url+"/index/banner")
    .then(res => {
      console.log(res.data);
      that.setData({
        banner:res.data
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
  }
})
