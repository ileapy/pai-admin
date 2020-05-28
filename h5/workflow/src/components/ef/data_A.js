var data_A = {
  name: '流程A',
  nodeList: [
    {
      id: 'n85vr4br9',
      name: '流程开始',
      type: 'start',
      left: '30px',
      top: '161px',
      ico: 'el-icon-video-play'
    },
    {
      id: 'nwl3pbmjho',
      name: '人员处理',
      type: 'people',
      left: '30px',
      top: '317px',
      ico: 'el-icon-user-solid'
    },
    {
      id: 'pebas950e9',
      name: '流程结束',
      type: 'end',
      left: '30px',
      top: '474px',
      ico: 'el-icon-video-pause'
    }
  ],
  lineList: [{
    from: 'n85vr4br9',
    to: 'nwl3pbmjho',
  }, {
    from: 'nwl3pbmjho',
    to: 'pebas950e9'
  }]
}

export function getDataA() {
  return data_A
}
