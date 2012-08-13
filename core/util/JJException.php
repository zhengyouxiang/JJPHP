<?php
/**
 *JJPHP 异常类
 * @package  coreutil
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
class JJException extends Exception {
    private $extra;
    private $type;
    public function __construct($message,$code=0,$extra=false) {
        parent::__construct($message,$code);
        $this->extra = $extra;
        $this->type=get_class($this);
    }
    public function __toString() {
        $trace = $this->getTrace();
        if($this->extra)
            array_shift($trace);
        $traceInfo='';
        $time = date('y-m-d H:i:m');
        foreach($trace as $t) {
            $traceInfo .= '['.$time.'] '.$t['file'].' ('.$t['line'].') ';
            $traceInfo .= $t['class'].$t['type'].$t['function'].'(';
            $traceInfo .=")";
        }
        JJLog::write($this->message." on ".$traceInfo, $this->type);
        return $this->message ;
    }

}