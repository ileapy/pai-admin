//app.js
var util = require('utils/util.js');

App({
  onLaunch: function () {
    // 小程序信息
    util.request(this.globalData.api_url + "/index/base").then((res) => {
      if (res.status == 200) {
        this.globalData.base = res.data
      }
    });
    // 登录
    wx.login({
      success: res => {
        // 发送 res.code 到后台换取 openId, sessionKey, unionId
        util.request(this.globalData.api_url + "/mini_program/openid", "POST", { code: res.code})
        .then((res) => {
          if(res.status === 200)
          {
            var tmp = res;
            this.globalData.session = tmp.data;
            // 获取用户信息
            wx.getSetting({
              success: res => {
                if (res.authSetting['scope.userInfo']) {
                  // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框
                  wx.getUserInfo({
                    success: res => {
                      // 可以将 res 发送给后台解码出 unionId
                      this.globalData.userInfo = res.userInfo
                      util.request(this.globalData.api_url + "/mini_program/login", "POST", 
                      { session_key: tmp.data.session_key,
                        encryptedData: res.encryptedData,
                        iv: res.iv
                      }).then((res)=>{
                        if(res.status === 200)
                        {
                          this.globalData.isLogin = true;
                          this.globalData.token = res.data.token
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
  globalData: {
    userInfo: null,
    session:null,
    api_url:"https://learn.leapy.cn/api",
    url:"https://learn.leapy.cn",
    isLogin:false,
    token:null,
    base:null
  }
})