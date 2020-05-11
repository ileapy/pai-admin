// pages/love/love.js
const app = getApp()
var util = require('../../utils/util.js')

Page({

  /**
   * 页面的初始数据
   */
  data: {
    is_send:false,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

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
   * 提交表单
   */
  toSubmit: function(e)
  {
    var that = this;
    if(this.data.is_send) return wx.showModal({
      title: '系统提示',
      content: '已经提交了',
    });
    var email = e.detail.value.email;
    var tel = e.detail.value.tel;
    var content = e.detail.value.content;
    if (!email) return wx.showModal({
      title: '系统提示',
      content: '邮箱不能为空',
    });
    if (!tel) return wx.showModal({
      title: '系统提示',
      content: '电话不能为空',
    });
    if (!content) return wx.showModal({
      title: '系统提示',
      content: '留言内容不能为空',
    });
    util.request(app.globalData.api_url+"/user/message","POST",{email:email,tel:tel,content:content},true).then((res)=>{
      if(res.status == 200)
      {
        wx.showModal({
          title: '系统提示',
          content: res.msg,
        });
        that.data.is_send = true;
      }else if(res.status == 400)
      {
        wx.showModal({
          title: '系统提示',
          content: res.msg,
        });
      }
    });
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