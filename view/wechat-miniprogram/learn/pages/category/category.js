// pages/category/category.js
const app = getApp()
var util = require('../../utils/util.js')

Page({

  /**
   * 页面的初始数据
   */
  data: {
    checkType:'',
    searchText:'',
    page:1,
    limit:10,
    bodyHeight:2000,
    lst:[],
    noMore:false,
    topNum:0,
    search:"",
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({
      'search': app.globalData.base.search
    });
    this.getData();
  },

  getData:function()
  {
    if (this.data.noMore) return;
    var that = this;
    util.request(app.globalData.api_url+"/video/lst","POST",{page:this.data.page,limit:this.data.limit,title:this.data.searchText,type:this.data.checkType},false).then((res)=>{
      if(res.data.length >= that.data.limit)  that.data.page = that.data.page+1;
      else that.data.noMore = true;
      that.setData({
        lst:that.data.lst.concat(res.data),
        noMore:that.data.noMore
      });
    });
  },

  inputText:function(e)
  {
    this.data.searchText = e.detail.value;
    this.data.page = 1;
    this.data.topNum = 0;
    this.data.noMore = false;
    this.data.lst = [];
    this.setData({
      topNum:this.data.topNum
    });
    this.getData();
  },

  cType:function(e)
  {
    this.data.checkType = e.currentTarget.dataset.type
    this.data.page = 1;
    this.data.noMore = false;
    this.data.topNum = 0;
    this.data.lst = [];
    this.setData({
      checkType:e.currentTarget.dataset.type,
      topNum:this.data.topNum
    });
    this.getData();
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

  // 播放
  play:function(e)
  {
    wx.navigateTo({
      url:"/pages/play/play?vid="+e.currentTarget.dataset.vid
    })
  },
})