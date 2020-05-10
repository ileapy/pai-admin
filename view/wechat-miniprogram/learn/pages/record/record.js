// pages/record/record.js
const app = getApp()
var util = require('../../utils/util.js')

Page({
  /**
   * 组件的初始数据
   */
  data: {
    lst:{},
  },

  /**
   * 加载数据
   */
  onLoad:function(options)
  {

  },

  onShow:function()
  {
    if (!app.globalData.isLogin) return wx.navigateTo({
      url: '/pages/login/login',
    });
    this.getData();
  },

  getData:function()
  {
    var that = this;
    util.request(app.globalData.api_url+"/video/record","POST",{},true).then((res)=>{
      that.setData({
        lst:res.data
      });
    });
  },

  // 图播放
  play(e)
  {
    wx.navigateTo({
      url:"/pages/play/play?vid="+e.currentTarget.dataset.vid
    })
  },
})
