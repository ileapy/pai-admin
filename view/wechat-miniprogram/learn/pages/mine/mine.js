// pages/mine/mine.js

const app = getApp()
var util = require('../../utils/util.js')

Component({
  /**
   * 组件的属性列表
   */
  properties: {

  },

  /**
   * 组件的初始数据
   */
  data: {
    nickname:"",
    avatar:""
  },

  /**
   * 组件的方法列表
   */
  methods: {
    // 加载页面
    onLoad:function()
    {
      var that = this;
      console.log(app.globalData)
      that.setData({
        nickname: app.globalData.userInfo.nickName,
        avatar: app.globalData.userInfo.avatarUrl
      });
    }
  }
})
