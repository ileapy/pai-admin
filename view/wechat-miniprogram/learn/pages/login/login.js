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

  onShow:function()
  {
    // 登录
    wx.login({
      success: res => {
        // 发送 res.code 到后台换取 openId, sessionKey, unionId
        util.request(app.globalData.api_url + "/mini_program/openid", "POST", { code: res.code})
        .then((res) => {
          if(res.status === 200)
          {
            var tmp = res;
            app.globalData.session = tmp.data;
            // 获取用户信息
            wx.getSetting({
              success: res => {
                if (res.authSetting['scope.userInfo']) {
                  // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框
                  wx.getUserInfo({
                    success: res => {
                      // 可以将 res 发送给后台解码出 unionId
                      app.globalData.userInfo = res.userInfo
                      util.request(app.globalData.api_url + "/mini_program/login", "POST", 
                      { session_key: tmp.data.session_key,
                        encryptedData: res.encryptedData,
                        iv: res.iv
                      }).then((res)=>{
                        if(res.status === 200)
                        {
                          app.globalData.isLogin = true;
                          app.globalData.token = res.data.token
                          wx.setStorageSync('token', res.data.token)
                        }
                      });
                      // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
                      // 所以此处加入 callback 以防止这种情况
                      if (this.userInfoReadyCallback) {
                        this.userInfoReadyCallback(res)
                      }
                    }
                  })
                }
              }
            })
          }
        })
      }
    })
  },

  bindGetUserInfo:function(e)
  {
    if (!e.detail.userInfo) return wx.showModal({
      title: '重要提示',
      content: '用户取消登录',
    })
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
          app.globalData.userInfo = res.data.userInfo
          wx.setStorageSync('token', res.data.token)
          var pages = getCurrentPages();
          if (pages.length > 1) {
            var beforePage = pages[pages.length - 2];//获取上一个页面实例对象
            if (beforePage.__route__ == 'pages/play/play') 
            {
              beforePage.play();
              return wx.navigateBack({
                delta: 1,
              })
            }else if(beforePage.__route__ == 'pages/mine/mine')
            {
              return wx.reLaunch({
                url: '/pages/mine/mine',
              })
            }else if(beforePage.__route__ == 'pages/collect/collect')
            {
              return wx.reLaunch({
                url: 'pages/collect/collect',
              })
            }
          }
          // 返回
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