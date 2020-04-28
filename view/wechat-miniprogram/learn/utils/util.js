const formatTime = date => {
  const year = date.getFullYear()
  const month = date.getMonth() + 1
  const day = date.getDate()
  const hour = date.getHours()
  const minute = date.getMinutes()
  const second = date.getSeconds()

  return [year, month, day].map(formatNumber).join('/') + ' ' + [hour, minute, second].map(formatNumber).join(':')
}

const formatNumber = n => {
  n = n.toString()
  return n[1] ? n : '0' + n
}

const request = function(url,type="GET",data={},isLogin=true)
{
  return new Promise(function(resolve, reject) 
  {
    wx.request({
      url: url,
      method: type,
      data:data,
      success:(res) => {
        if(res.statusCode === 200) resolve(res.data);
        else resolve(res)
      },
      fail(res)
      {
        reject(res)
      }
    })
  })
}

module.exports = {
  formatTime: formatTime,
  request:request
}
