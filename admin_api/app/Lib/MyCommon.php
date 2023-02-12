<?php

namespace App\Lib;
use GuzzleHttp\Client;
use Psr\Http\Message\ServerRequestInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Bean\BeanFactory;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Redis\Redis;
use App\Lib\MyValidator;
use App\Lib\MyRedisHelper;
use App\Lib\MyPagination;

/**
 * 公共函数类
 * Class MyCommon
 * @package App\Lib
 * @Bean("MyCommon")
 */
class MyCommon
{
    /**
     * 分页
     * @param string $table
     * @param array $where
     * @param int $page_index
     * @return array
     * @throws DbException
     */
    public static function list_page(string $table = '', array $where = array(), int $page_index = 1)
    {
        $per_num = config('per_page_num');
        $data['info'] = DB::table($table)->where($where)->forPage($page_index, $per_num)->get()->toArray();
        $data['count'] = DB::table($table)->where($where)->count();

        $request = context()->getRequest();
        $get = $request->get();
        if (isset($get['page_index'])) {
            unset($get['page_index']);
        }
        $string_param = !empty($get) ? '?' . http_build_query($get) : '';
        $page_base_url = $request->getUriPath().$string_param;
        $myPagination = BeanFactory::getBean('MyPagination');

        $config['base_url'] = $page_base_url;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page_index';
        $config['total_rows'] = $data['count'];
        $config['per_page'] = $per_num;
        $config['use_page_numbers'] = TRUE;
        $config['cur_page'] = $page_index;
        $config['full_tag_open'] = '<div class="pagination text-r mt-15"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['first_link'] = '&lt;&lt;';
        $config['first_tag_open'] = '<li>';//“第一页”链接的打开标签。
        $config['first_tag_close'] = '</li>';//“第一页”链接的关闭标签。
        $config['last_link'] = '&gt;&gt;';//你希望在分页的右边显示“最后一页”链接的名字。
        $config['last_tag_open'] = '<li>';//“最后一页”链接的打开标签。
        $config['last_tag_close'] = '</li>';//“最后一页”链接的关闭标签。
        $config['next_link'] = '&gt;';//你希望在分页中显示“下一页”链接的名字。
        $config['next_tag_open'] = '<li>';//“下一页”链接的打开标签。
        $config['next_tag_close'] = '</li>';//“下一页”链接的关闭标签。
        $config['prev_link'] = '&lt;';//你希望在分页中显示“上一页”链接的名字。
        $config['prev_tag_open'] = '<li>';//“上一页”链接的打开标签。
        $config['prev_tag_close'] = '</li>';//“上一页”链接的关闭标签。
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void()">';//“当前页”链接的打开标签。
        $config['cur_tag_close'] = '</a></li>';//“当前页”链接的关闭标签。
        $config['num_tag_open'] = '<li>';//“数字”链接的打开标签。
        $config['num_tag_close'] = '</li>';
        $myPagination->initialize($config);
        $data['page_view'] = $myPagination->create_links();
        return $data;
    }

    /**
     * 分页
     * @param array $data
     * @param int $page_index
     * @return array
     */
    public static function list_page_query_sql(array $data, int $page_index = 1)
    {
        $per_num = config('per_page_num');
        $request = context()->getRequest();
        $get = $request->get();
        if (isset($get['page_index'])) {
            unset($get['page_index']);
        }
        $string_param = !empty($get) ? '?' . http_build_query($get) : '';
        $page_base_url = $request->getUriPath().$string_param;
        $myPagination = BeanFactory::getBean('MyPagination');

        $config['base_url'] = $page_base_url;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page_index';
        $config['total_rows'] = $data['count'];
        $config['per_page'] = $per_num;
        $config['use_page_numbers'] = TRUE;
        $config['cur_page'] = $page_index;
        $config['full_tag_open'] = '<div class="pagination text-r mt-15"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['first_link'] = '&lt;&lt;';
        $config['first_tag_open'] = '<li>';//“第一页”链接的打开标签。
        $config['first_tag_close'] = '</li>';//“第一页”链接的关闭标签。
        $config['last_link'] = '&gt;&gt;';//你希望在分页的右边显示“最后一页”链接的名字。
        $config['last_tag_open'] = '<li>';//“最后一页”链接的打开标签。
        $config['last_tag_close'] = '</li>';//“最后一页”链接的关闭标签。
        $config['next_link'] = '&gt;';//你希望在分页中显示“下一页”链接的名字。
        $config['next_tag_open'] = '<li>';//“下一页”链接的打开标签。
        $config['next_tag_close'] = '</li>';//“下一页”链接的关闭标签。
        $config['prev_link'] = '&lt;';//你希望在分页中显示“上一页”链接的名字。
        $config['prev_tag_open'] = '<li>';//“上一页”链接的打开标签。
        $config['prev_tag_close'] = '</li>';//“上一页”链接的关闭标签。
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void()">';//“当前页”链接的打开标签。
        $config['cur_tag_close'] = '</a></li>';//“当前页”链接的关闭标签。
        $config['num_tag_open'] = '<li>';//“数字”链接的打开标签。
        $config['num_tag_close'] = '</li>';
        $myPagination->initialize($config);
        $data['page_view'] = $myPagination->create_links();
        return $data;
    }

	/**
     * 获取毫秒数时间戳
     * @return type
     */
    public static function getMillisecond()
    {
        $microtime = microtime(true);
        return (round($microtime * 1000));
    }

    /**
     * 判断是否是邮箱
     * @param string $email
     * @return bool
     */
    public function is_email(string $email): bool
    {
        preg_match('/^[A-Za-z0-9][\w\-\.]+\@([\w\-])+\.[\w\-]+$/',$email,$rs);
        if(empty($rs)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 判断是否是手机号码
     * @param string $mobile
     * @param string $area_code
     * @return bool
     */
    public function is_mobile(string $mobile, string $area_code): bool
    {
        $preg = config('mobile_preg.'.$area_code);
        if (!$preg){
            //默认86
            $preg = config('mobile_preg.86');
        }
        preg_match($preg, $mobile,$rs);
        if(empty($rs)){
            return false;
        }else{
            return true;
        }
    }

    /**
    *写入日志
    */
    public static function write_log($data, $path = '/logs/default')
    {
        if (!is_string($data)) {
            return false;
        }
        $filename = $path .'/'. date("Y_m_d") . '.log';
        if(!is_dir($path)){
            mkdir($path, 0777, true);
        }
        $time = date("Y-m-d H:i:s");
        $content = "日期：".$time."----信息：".$data . PHP_EOL;
        //异步写入日志
        file_put_contents($filename, $content, FILE_APPEND);
        unset($data, $path, $filename, $time, $content);
        return true;
    }

    /**
     * @param $account
     * @param $area_code
     * @param $temp_key
     * @param $action_name
     * @param $send_data
     * @return bool|int
     */
    public function push_notice_queue_old(string $account, string $area_code, string $temp_key, string $action_name = '', array $send_data = []): bool
    {
        $myValidator = BeanFactory::getBean('MyValidator');
        $account_type = $myValidator->account_check($account);
        $data = [
            'type' => $account_type,
            'account' => $account,
            'area_code' => $area_code,
            'temp_key' => $temp_key,
            'action_name' => $action_name,
            'send_data' => $send_data
        ];
        return Redis::lPush('notice_list_key', json_encode($data));

    }

    /**
     * @param $account
     * @param $area_code
     * @param $temp_key
     * @param $action_name
     * @param $send_data
     * @return bool|int
     */
    public function push_notice_queue(string $account, string $area_code, string $temp_key, string $action_name = '', array $send_data = []): bool
    {
        $myValidator = BeanFactory::getBean('MyValidator');
        $account_type = $myValidator->account_check($account, $area_code);
        $myRabbitMq = BeanFactory::getBean('MyRabbitMq');
        $data = [
            'unique_id' => $this->get_unique_id($account),
            'type' => $account_type,
            'account' => $account,
            'area_code' => $area_code,
            'temp_key' => $temp_key,
            'action_name' => $action_name,
            'send_data' => $send_data
        ];
        return $myRabbitMq->push('notice_list_key', $data);

    }

    /**
     * 获取令牌
     * @param string $prefix
     * @return string
     */
    public function get_token(string $prefix)
    {
        return hash_hmac('md5', $prefix.MyCommon::getMillisecond(), uniqid("", true));
    }

    /**
     * 创建唯一id
     * @param string $prefix
     * @return string
     */
    public function get_unique_id($prefix = ''): string
    {
        $rand = mt_rand(0, 10000);
        $time = $this->getMillisecond();
        return $prefix.'_'.$time.'_'.$rand;
    }


    /**
     * 拼接正确的文件路径
     * @param string $path
     * @param string $type
     * @return string
     */
	public static function get_filepath($path = "", $type = 'qiniu')
	{
	    if ($type === 'qiniu') {
            return config('qiniu_domain') . '/' . $path;
        } else {
            return config('file_domain') . '/' . $path;
        }

//		if(strpos($path, USER_UPLOAD_PATH) === false && strpos($path, "static/") === false){
//			return config('qiniu_domain') . '/' . $path;
//		}else{
//			return base_url() . $path;
//		}
	}

    /**
     * @param $path
     * @param string $type
     * @return bool|false|string
     */
    public static function get_filename($path, $type = 'qiniu')
    {
        if ($type === 'qiniu') {
            $domain = config('qiniu_domain');
        } else {
            $domain = config('file_domain');
        }

        $pos_res = strpos($path, $domain);
        if($pos_res === false || $pos_res != 0){
            return false;
        }
        $len = strlen($domain . '/');
        return substr($path, $len);
    }

    /**
     * 检查字符串是否为空，为空返回true, 否则返回false
     * @param type $str
     * @return boolean
     */
    public static function checkEmpty($str)
    {
        if(!isset($str)){
            return true;
        }
        if($str === NULL){
            return true;
        }
        if(trim($str) === ''){
            return true;
        }
        return false;
    }

    //获取当前时间到今天结束时间的秒数
    public function get_cur_day_time()
    {
        $date = date("Y-m-d", strtotime("+1 day"));
        return strtotime($date) - time();
    }

    //手机号码中间加六个星号
    public function phoneCipher($phone, $start, $len)
    {
        $chiper = '*';
        for($i = 1; $i < $len; $i++){
            $chiper .= '*';
        }
        return substr_replace($phone, $chiper, $start, $len);
    }

    //姓名加星号
    public function nameCipher($name, $start, $len)
    {
        $start = $start*3;
        $chiper = '*';
        for($i = 1; $i < $len; $i++){
            $chiper .= '*';
        }
        $len = $len*3;
        return substr_replace($name, $chiper, $start, $len);
    }

    //创建随机手机号
    public function createPhone()
    {
        $data = [134,135,136,137,138,139,147,150,151,152,157,158,159,178,182,183,184,187,188,130,131,132,155,156,185,186,145,176];
        $len = count($data);
        $prefix = $data[mt_rand(0, ($len - 1))];
        $middle = str_pad(mt_rand(0,9999), 4, 0, STR_PAD_LEFT);
        $suffix = mt_rand(1027, 9851);
        return $prefix . $middle . $suffix;
    }

    public function createEmail($phone)
    {
        $data = ['163', 'qq'];
        $len = count($data);
        $company = $data[mt_rand(0, ($len - 1))];
        if($company === 'qq'){
            $email = mt_rand(1000000, 2345678910) . '@qq.com';
        }else{
            $email = $phone . '@163.com';
        }
        return $email;
    }

    /**
     * 防止重复点击
     * @param $key
     * @param int $timeout
     * @return bool
     */
    public function can_not_repeat_click(string $key, int $timeout = 2): bool
    {
        $script = '
            if redis.call("incr", KEYS[1]) then
                if redis.call("expire", KEYS[1], ARGV[1]) then
                    return redis.call("get", KEYS[1])
                end
            else
                return 2
            end
        ';
        $is_ex = Redis::eval($script, [$key, $timeout], 1);
        if($is_ex > 1){
            return true;
        }
        return false;
    }

    //取消点击状态
    public function close_click_status($key)
    {
        return Redis::del($key);
    }


    //根据name获取配置表信息
    public function config_info($name, $group = 0)
    {
        if($group === 0){
            $data = $this->ci->db->where(['name' => $name, 'cancel_flag' => 0])->get('config')->row_array();
        }else{
            $data = $this->ci->db->where(['name' => $name, 'group' => $group, 'cancel_flag' => 0])->get('config')->row_array();
        }
        return $data;
    }

    //根据group获取配置表信息
    public function config_info_group($group)
    {
        $data = $this->ci->db->where(['group' => $group, 'cancel_flag' => 0])->get('config')->result_array();
        return $data;
    }

    /**
     * 获取字符串的余数hash值
     * @param $key
     * @param $remainder
     * @return string|null
     */
    public function get_hash_id($key, $remainder)
    {
        //如果是数字，取余返回
        if(is_numeric($key)){
            return bcmod($key, $remainder);
        }
        $str_num = crc32(strtolower($key));
        return bcmod($str_num, $remainder);
    }

    /**
     * 获取客户端ip
     * @param ServerRequestInterface $request
     * @return mixed
     */
    public static function get_ip(ServerRequestInterface $request): string
    {
        $services = array_merge($request->getHeaderLines(), $request->getServerParams());
        $ip = $services['remote_addr'];
        if (isset($services['x-forwared-for'])){
            $ip = $services['x-forwared-for'];
        }
        if (isset($services['x-real-ip'])){
            $ip = $services['x-real-ip'];
        }
        return $ip;
    }

    /**
     * 获取ip归属地
     * @param string $ip
     * @return string
     */
    public function get_ip_area(string $ip): string
    {
        $myIp = new MyIP();
        $ip_info = $myIp->find($ip);
        return implode(' ', $ip_info);
    }

    /**
     * 获取浮点数长度
     * @param type $num
     * @return type
     */
    public function getFloatLength($num) {
        $count = 0;
        $temp = explode ( '.', $num );
        if (sizeof ( $temp ) > 1) {
            $decimal = end ( $temp );
            $count = strlen ( $decimal );
        }
        return $count;
    }

    //去除掉所有空格
    public function trimall($str)
    {
        $find = [' ', "\n", "\r", "\t"];
        $replace = ['','','',''];
        return str_replace($find, $replace, $str);
    }

    //冒泡排序，降序
    public function bubble_rsort($data, $key)
    {
        $count = count($data);
        if($count > 1){
            for($i = 1; $i < $count; $i++){
                for($j = 0; $j < $count - $i; $j++){
                    if($data[$j][$key] < $data[$j+1][$key]){
                        $tmp = $data[$j+1];
                        $data[$j+1] = $data[$j];
                        $data[$j] = $tmp;
                        unset($tmp);
                    }
                }
            }
        }
        return $data;
    }

    //冒泡排序，升序
    public function bubble_sort($data, $key)
    {
        $count = count($data);
        if($count > 1){
            for($i = 1; $i < $count; $i++){
                for($j = 0; $j < $count - $i; $j++){
                    if($data[$j][$key] > $data[$j+1][$key]){
                        $tmp = $data[$j+1];
                        $data[$j+1] = $data[$j];
                        $data[$j] = $tmp;
                        unset($tmp);
                    }
                }
            }
        }
        return $data;
    }

    //获取平均值
    public function get_aver_value(array $datas)
    {
        $sum = 0;
        $len = count($datas);
        foreach ($datas as $value){
            $sum += $value;
        }
        return bcdiv($sum, $len, 6);
    }


    /**
     * @param $account
     * @param $area_code
     * @param $action
     * @return bool|int
     */
    public function send_verify_code(string $account, string $area_code, string $action)
    {
        $code_key = $action. '_code_key';
        $code = mt_rand(100000, 999999);
        $action_name = config('actions.'.$action);
        $send_data = [
            $code,
            $action_name,
            config('code_expire_time'),
        ];
        $temp_key = 'code_temp_id';
        $res = $this->push_notice_queue($account, $area_code, $temp_key, $action_name, $send_data);
        if ($res){
            $set_redis = [
                'create_time' => time(),
                'code' => $code,
            ];
            $res = MyRedisHelper::hSet($code_key, $account, $set_redis);
            if ($res) {
                return $code;
            }
            return false;
        }
        return false;
    }

    /**
     * 获取用户密码
     * author l
     * date  2020-07-17
     * @param string $password 密码
     * @return string
     */
    public static function create_user_password(string $password) :string
    {
        if(!$password){
            throw new \RuntimeException('密码不能为空');
        }

        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * 设置用户提现的数量
     * @param $key
     * @param $uid
     * @param $amount
     */
    public function set_withdraw_amount($key, $uid, $amount): void
    {
        Redis::hIncrByFloat($key, (string)$uid, (float)$amount);
        Redis::expire($key, $this->get_cur_day_time());
    }



}
