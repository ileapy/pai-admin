// pages/login/login.js
const app = getApp()
var util= require('../../utils/util.js')

Page({

  /**
   * 页面的初始数据
   */
  data: {
    icon:"",
    name:"",
    url:app.globalData.url
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({
      icon: app.globalData.base.icon,
      name: app.globalData.base.name
    });
  },

  bindGetUserInfo:function(e)
  {
    if (!e.detail.userInfo) return wx.showModal({
      title: '重要提示',
      content: '用户取消登录',
    })
    console.log(e)
    util.request(app.globalData.api_url + "/mini_program/login", "POST",
      {
        session_key: app.globalData.session.session_key,
        encryptedData: e.detail.encryptedData,
        iv: e.detail.iv
      }).then((res) => {
        console.log(res)
        if (res.status === 200) {
          app.globalData.isLogin = true;
          app.globalData.token = res.data.token
          var pages = getCurrentPages();
          if (pages.length > 1) {
            var beforePage = pages[pages.length - 2];//获取上一个页面实例对象
            beforePage.play();
          }
          wx.navigateBack({
            delta: 1,
          })
        }else
        {
          wx.showModal({
            title: '重要提示',
            content: '登录失败，请联系管理员',
          })
        }
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

  },

  getUserInfo: function(e) {

  }
})