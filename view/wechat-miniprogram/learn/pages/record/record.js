// pages/record/record.js
const app = getApp()
var util = require('../../utils/util.js')

Page({
  /**
   * 组件的初始数据
   */
  data: {
    lst:[],
    noMore: false,
    topNum: 0,
    page: 1,
    limit: 10,
    bodyHeight: 2000,
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
    if (this.data.noMore) return;
    var that = this;
    util.request(app.globalData.api_url + "/video/record", "POST", { page: this.data.page, limit: this.data.limit },true).then((res)=>{
      if (res.data.length >= that.data.limit) that.data.page = that.data.page + 1;
      else that.data.noMore = true;
      that.setData({
        lst: that.data.lst.concat(res.data),
        noMore: that.data.noMore
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
