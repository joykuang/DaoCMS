<?php
namespace Note\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function _empty(){
		echo "<title>404 File Not Found! </title>";
        echo ":-(  出问题了？<br>很不幸地告诉你，您访问的网址出事了！";
    }	
	/*
    public function index(){
        echo "服务器系统：" .get_os(). "<br>";
        echo "服务器软件：" .$_SERVER["SERVER_SOFTWARE"]. "<br>";
        echo "解析器版本：PHP " .phpversion(). "<br>";        
        echo "当前浏览器：" .$_SERVER["HTTP_USER_AGENT"]. "<br>";
        echo "图像库版本：GD " .gd_info()["GD Version"]."<br>";
        echo "数据库版本：" ."SQLite ".phpversion("sqlite3")."<br>";
        echo "加速器版本：Zend Engine " .zend_version()."<br>";
        echo "内存使用率：" .convert(memory_get_usage(true)). " / 8388608 KB";
    }*/
        
    public function index(){
        $note = M('notes');
		$note_item = $note->limit(10)->select();		
		//dump($note_item);
		echo '
		<style>
		table { 
			border-collapse:collapse;
			border-spacing:0 
		}
		
		td { 
			padding: 5px;
			border: 1px solid #aaa;
		}
		</style>
		';		
		
		
		echo '
		<table><tr><td>#</td><td>标题</td><td>作者</td><td>标签</td><td>时间</td><td>操作</td></tr>
		';
		
		foreach ($note_item as $key => $value) {
			echo '<tr>';
			echo '<td>'.($key+1).'</td>';
			echo '<td>'.$value['title'].'</td>';
			echo '<td>'.$value['aid'].'</td>';
			echo '<td>'.$value['tag'].'</td>';			
			echo '<td>'.$value['display_date'].'</td>';
			echo '<td><a href="/Note/Admin/editnote?nid='.$value['nid'].'">编辑</a>  <a href="/Note/Admin/delete?nid='.$value['nid'].'">删除</a></td>';		
			echo '</tr>';
		}
		
		echo '
		</table>
		';
		
		echo '<br>任务：<a href="/Note/Admin/newnote">新建笔记</a>  <a href="/Note/Admin/index">笔记管理</a>';
    }	

    public function note(){
		$nid = $_GET['nid'];
		
		if ($nid < 1) echo '404 Note Not Found!';
		else {
		
			$note = M('notes');
			$note_item = $note->where(' nid='.$nid.' ' )->find();		
			if ($note_item == null) echo '找不到该笔记！';
			else {
				echo '笔记标题：';
				echo $note_item['title'];
				
				echo '<br>笔记标签：';
				echo $note_item['tag'];
				
				echo '<br>笔记时间：';
				echo $note_item['display_date'];
	
				echo '<br>笔记正文：';
				echo $note_item['content'];			
				
				echo '<br><a href="/Note/Index/index">返回目录</a>';
			}
		}
    }	
		
    public function dt(){
		dump ($_GET);
    }				
}

