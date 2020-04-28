// pages/play/play.js
//获取应用实例
const app = getApp()
var util= require('../../utils/util.js')

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
    video_url:""
  },

  /**
   * 组件的方法列表
   */
  methods: {
    onLoad: function (options) {
      this.info(options.vid)
    },
    info:function(vid)
    {
      var that = this;
      util.request(app.globalData.api_url+"/video/url","POST",{vid:vid}).then((res) => {
        console.log(res);
        if(res.status == 200)
        {
          that.setData({
            video_url:res.data.url
          });
        }
      })
      .catch((res)=>{
        console.log(res);
      })
    }
  }
})
