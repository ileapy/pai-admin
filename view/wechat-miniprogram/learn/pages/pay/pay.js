// pages/pay/pay.js
const app = getApp()
var util = require('../../utils/util.js')


Page({

  /**
   * 页面的初始数据
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
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.getData();
  },

  getData:function()
  {
    if (this.data.noMore) return;
    var that = this;
    util.request(app.globalData.api_url + "/order/buy", "POST", { page: this.data.page, limit: this.data.limit },true).then((res)=>{
      if (res.data.length >= that.data.limit) that.data.page = that.data.page + 1;
      else that.data.noMore = true;
      that.setData({
        lst: that.data.lst.concat(res.data),
        noMore: that.data.noMore
      });
    });
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})