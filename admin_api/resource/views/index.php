<section class="Hui-article-box">
    <div class="wrapper">
        <div class="pie-charts">
            <div class="user-chart pie-chart--wrapper">
              <h2>用户数据</h2>
              <div class="pie-chart">
                  <div class="pie-chart__pie"></div>
                  <ul class="pie-chart__legend">
                    <li><em>注册用户</em><span>1</span></li>
                    <li><em>今日注册用户</em><span>1</span></li>
                    <li><em>在线用户</em><span>1</span></li>
                    <li><em>实名认证用户</em><span>1</span></li>
                    <li><em>今日实名认证用户</em><span>1</span></li>
                  </ul>
              </div>
            </div>
            <div class="c2c-chart pie-chart--wrapper">
              <h2>法币交易数据</h2>
              <div class="pie-chart">
                  <div class="pie-chart__pie"></div>
                  <ul class="pie-chart__legend">
                    <li><em>今日用户充值数(USDT)</em><span>1</span></li>
                    <li><em>今日用户提现数(USDT)</em><span>2</span></li>
                    <li><em>今日活动赠送数(USDT)</em><span>3</span></li>
                    <li><em>用户总充值数(USDT)</em><span>0</span></li>
                    <li><em>用户总提现数(USDT)</em><span>0</span></li>
                    <li><em>活动总赠送数(USDT)</em><span>0</span></li>
                  </ul>
              </div>
            </div>
            <div class="vendor-chart pie-chart--wrapper">
              <h2>商家数据</h2>
              <div class="pie-chart">
                  <div class="pie-chart__pie"></div>
                  <ul class="pie-chart__legend">
                    <li><em>注册商家</em><span>100</span></li>
                  </ul>
              </div>
            </div>
        </div>
    </div>
</section>
<script>
function sliceSize(dataNum, dataTotal) {
  return (dataNum / dataTotal) * 360;
}

function addSlice(id, sliceSize, pieElement, offset, sliceID, color) {
  $(pieElement).append("<div class='slice "+ sliceID + "'><span></span></div>");
  var offset = offset - 1;
  var sizeRotation = -179 + sliceSize;

  $(id + " ." + sliceID).css({
    "transform": "rotate(" + offset + "deg) translate3d(0,0,0)"
  });

  $(id + " ." + sliceID + " span").css({
    "transform"       : "rotate(" + sizeRotation + "deg) translate3d(0,0,0)",
    "background-color": color
  });
}

function iterateSlices(id, sliceSize, pieElement, offset, dataCount, sliceCount, color) {
  var
    maxSize = 179,
    sliceID = "s" + dataCount + "-" + sliceCount;

  if( sliceSize <= maxSize ) {
    addSlice(id, sliceSize, pieElement, offset, sliceID, color);
  } else {
    addSlice(id, maxSize, pieElement, offset, sliceID, color);
    iterateSlices(id, sliceSize-maxSize, pieElement, offset+maxSize, dataCount, sliceCount+1, color);
  }
}

function createPie(id) {
  var
    listData      = [],
    listTotal     = 0,
    offset        = 0,
    i             = 0,
    pieElement    = id + " .pie-chart__pie"
    dataElement   = id + " .pie-chart__legend"

    color         = [
      "rgb(187,228,255)",
      "rgb(2,166,209)",
      "rgb(5,116,206)",
      "rgb(239,71,111)",
      "rgb(255,209,102)",
      "rgb(6,214,160)",
      "rgb(172,78,221)",
      "rgb(255,140,62)",
      "rgb(0,188,212)",
      "rgb(194,24,91)",
      "rgb(230,74,25)",
      "rgb(103,58,183)"
    ];

  color = shuffle( color );

  $(dataElement+" span").each(function() {
    listData.push(Number($(this).html()));
  });

  for(i = 0; i < listData.length; i++) {
    listTotal += listData[i];
  }
  if (listTotal == 0) return;

  for(i=0; i < listData.length; i++) {
    var size = sliceSize(listData[i], listTotal);
    iterateSlices(id, size, pieElement, offset, i, 0, color[i]);
    $(dataElement + " li:nth-child(" + (i + 1) + ")").css("border-color", color[i]);
    offset += size;
  }
}

function shuffle(a) {
    var j, x, i;
    for (i = a.length; i; i--) {
        j = Math.floor(Math.random() * i);
        x = a[i - 1];
        a[i - 1] = a[j];
        a[j] = x;
    }

    return a;
}

function createPieCharts() {
  // createPie('.pieID--region' );
  createPie('.user-chart');
  createPie('.c2c-chart');
  createPie('.vendor-chart');
}

createPieCharts();
</script>
