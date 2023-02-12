
<!--_menu 作为公共模版分离出去-->
<aside class="Hui-aside">

	<div class="menu_dropdown bk_2">
<!--        <dl id="menu-article">-->
<!--			<a href="/admin" title="首页"><dt><i class="Hui-iconfont">&#xe616;</i> 首页</dt></a>-->
<!--		</dl>-->
<!--    <dl id="menu-admin">-->
<!--      <dt><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--      <dd>-->
<!--        <ul>-->
<!--            <li><a href="/admin/add" title="添加管理员">添加管理员</a></li>-->
<!--            <li><a href="/admin/index" title="管理员列表">管理员列表</a></li>-->
<!--        </ul>-->
<!--      </dd>-->
<!--    </dl>-->
        <?php foreach($data['common_info']['left_menu'] as $value): ?>
            <dl id="menu-article">
                <?php if(!isset($value['sub_menu'])):?>
                    <a href="/admin" style="text-decoration-line: none" title="<?php echo $value['action_name'] ?>"><dt><i class="Hui-iconfont">&#xe616;</i> <?php echo $value['action_name'] ?></dt></a>
                <?php else: ?>
                    <dt><i class="Hui-iconfont">&#xe616;</i> <?php echo $value['action_name'] ?><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
                    <dd>
                        <ul>
                            <?php foreach($value['sub_menu'] as $val): ?>
                                <li><a href="<?php echo $val['action_url']?>" title="<?php echo $val['action_name']?>"><?php echo $val['action_name']?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </dd>
                <?php endif ?>
            </dl>
        <?php endforeach ?>
        <?php if(isset($data['common_info']['user']['admin_type']) && $data['common_info']['user']['admin_type'] == '1'):?>
        <dl id="menu-admin">
            <dt><i class="Hui-iconfont">&#xe62d;</i> 角色管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a href="/role/index" title="角色列表">角色列表</a></li>
                    <li><a href="/role/add" title="添加角色">添加角色</a></li>
                    <li><a href="/role/action" title="权限列表">权限列表</a></li>
                    <li><a href="/role/add_action" title="添加权限">添加权限</a></li>
                </ul>
            </dd>
        </dl>
        <?php endif ?>
<!--		<dl id="menu-article">-->
<!--			<dt><i class="Hui-iconfont">&#xe616;</i> 币种管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="/coin" title="币种管理">币种列表</a></li>-->
<!--					<li><a href="/coin/add" title="币种管理">添加币种</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!--		<dl id="menu-article">-->
<!--			<dt><i class="Hui-iconfont">&#xe616;</i> 活动管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="/active">活动惠率列表</a></li>-->
<!--					<li><a href="/active/add">添加活动惠率</a></li>-->
<!--					<li><a href="/active/increments">月度忠实用户增值</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!--		<dl id="menu-article">-->
<!--			<dt><i class="Hui-iconfont">&#xe616;</i> 首页轮播图片管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="/Bannerimg">图片列表</a></li>-->
<!--					<li><a href="/Bannerimg/add">添加轮播图片</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!--		<dl id="menu-article">-->
<!--			<dt><i class="Hui-iconfont">&#xe616;</i> 模拟数据管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="/data/testUserList">用户前端测试账号列表</a></li>-->
<!--					<li><a href="/data/addTestUser">添加用户前端测试账号</a></li>-->
<!--					<li><a href="/data/rechargeUser">用户充值</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!---->
<!--		<dl id="menu-article">-->
<!--			<dt><i class="Hui-iconfont">&#xe616;</i> 法币交易<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="/C2C/orders" title="法币交易管理">订单</a></li>-->
<!--					<li><a href="/C2C/statistics" title="法币交易管理">充值/提现统计</a></li>-->
<!--					<li><a href="/C2C/rg_log" title="法币交易管理">充值送BC统计</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!---->
<!--		<dl id="menu-article">-->
<!--			<dt><i class="Hui-iconfont">&#xe616;</i> 币币交易<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="/trade/trade_log" title="币币交易管理">交易记录</a></li>-->
<!--					<li><a href="/trade/dw_log" title="币币交易管理">充值/提现记录</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!---->
<!--		<dl id="menu-article">-->
<!--			<dt><i class="Hui-iconfont">&#xe616;</i> 统计管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="/count/charge_withdraw_count" title="充值/提现统计">充值/提现统计</a></li>-->
<!--					<li><a href="/count/statistics_new" title="用户余额变化统计">用户余额变化统计</a></li>-->
<!--					<li><a href="/count/recommend_partition" title="推荐人推荐排名统计">推荐人推荐排名统计</a></li>-->
<!--					<li><a href="/count/user_register" title="新用户注册汇总统计">新用户注册汇总统计</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!---->
<!--		<dl id="menu-article">-->
<!--			<dt><i class="Hui-iconfont">&#xe616;</i> 文章管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="/article" title="article">文章列表</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!---->
<!--  <dl id="menu-article">-->
<!--			<dt><i class="Hui-iconfont">&#xe616;</i> 用户<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!---->
<!--					<li><a href="/user/index" title="用户">用户列表</a></li>-->
<!--					<li><a href="/user/workorders" title="用户">工单管理</a></li>-->
<!--					<li><a href="/user/forbiddens" title="用户">违规禁止名单</a></li>-->
<!--					<li><a href="/user/identify" title="用户">身份认证审核</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!---->
<!--  <dl id="menu-article">-->
<!--			<dt><i class="Hui-iconfont">&#xe616;</i> 设置<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="/config/get_fee_list" title="设置">手续费率</a></li>-->
<!--					<li><a href="/config/modify_pwd" title="设置">修改密码</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!---->
<!--		<dl id="menu-article">-->
<!--			<dt><i class="Hui-iconfont">&#xe616;</i> 商家管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="/vendor" title="vendor">商家列表</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!--		<dl id="menu-picture">-->
<!--			<dt><i class="Hui-iconfont">&#xe613;</i> 图片管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="picture-list.html" title="图片管理">图片管理</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!--		<dl id="menu-product">-->
<!--			<dt><i class="Hui-iconfont">&#xe620;</i> 产品管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="product-brand.html" title="品牌管理">品牌管理</a></li>-->
<!--					<li><a href="product-category.html" title="分类管理">分类管理</a></li>-->
<!--					<li><a href="product-list.html" title="产品管理">产品管理</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!--		<dl id="menu-comments">-->
<!--			<dt><i class="Hui-iconfont">&#xe622;</i> 评论管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="http://h-ui.duoshuo.com/admin/" title="评论列表">评论列表</a></li>-->
<!--					<li><a href="feedback-list.html" title="意见反馈">意见反馈</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!--		<dl id="menu-member">-->
<!--			<dt><i class="Hui-iconfont">&#xe60d;</i> 会员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="member-list.html" title="会员列表">会员列表</a></li>-->
<!--					<li><a href="member-del.html" title="删除的会员">删除的会员</a></li>-->
<!--					<li><a href="member-level.html" title="等级管理">等级管理</a></li>-->
<!--					<li><a href="member-scoreoperation.html" title="积分管理">积分管理</a></li>-->
<!--					<li><a href="member-record-browse.html" title="浏览记录">浏览记录</a></li>-->
<!--					<li><a href="member-record-download.html" title="下载记录">下载记录</a></li>-->
<!--					<li><a href="member-record-share.html" title="分享记录">分享记录</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!--		<dl id="menu-tongji">-->
<!--			<dt><i class="Hui-iconfont">&#xe61a;</i> 系统统计<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="charts-1.html" title="折线图">折线图</a></li>-->
<!--					<li><a href="charts-2.html" title="时间轴折线图">时间轴折线图</a></li>-->
<!--					<li><a href="charts-3.html" title="区域图">区域图</a></li>-->
<!--					<li><a href="charts-4.html" title="柱状图">柱状图</a></li>-->
<!--					<li><a href="charts-5.html" title="饼状图">饼状图</a></li>-->
<!--					<li><a href="charts-6.html" title="3D柱状图">3D柱状图</a></li>-->
<!--					<li><a href="charts-7.html" title="3D饼状图">3D饼状图</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
<!--		<dl id="menu-system">-->
<!--			<dt><i class="Hui-iconfont">&#xe62e;</i> 系统管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--			<dd>-->
<!--				<ul>-->
<!--					<li><a href="system-base.html" title="系统设置">系统设置</a></li>-->
<!--					<li><a href="system-category.html" title="栏目管理">栏目管理</a></li>-->
<!--					<li><a href="system-data.html" title="数据字典">数据字典</a></li>-->
<!--					<li><a href="system-shielding.html" title="屏蔽词">屏蔽词</a></li>-->
<!--					<li><a href="system-log.html" title="系统日志">系统日志</a></li>-->
<!--				</ul>-->
<!--			</dd>-->
<!--		</dl>-->
	</div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<!--/_menu 作为公共模版分离出去-->
