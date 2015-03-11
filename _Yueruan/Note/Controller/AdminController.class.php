<?php
namespace Note\Controller;
use Think\Controller;
class AdminController extends Controller {
    public function _empty(){
		echo "<title>404 File Not Found! </title>";
        echo ":-(  出问题了？<br>很不幸地告诉你，您访问的网址出事了！";
    }	

    public function index(){
        $note = M('notes');
		$note_item = $note->limit(10)->select();		
		if ($note_item == null) echo '无笔记！<a href="/Note/Admin/newnote">点击新建笔记</a> ';
		else {
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
    }		
	
    public function newnote(){
		echo "<title>新建笔记</title>";
        echo '
		<form action="/Note/Admin/savenote?do=new" method="post">
		标题：<input type="text" name="title"><br><br>
		标签：<input type="text" name="tag"><br><br>
		作者：<input type="text" name="author"><br><br>	
		正文：<textarea name="content" style="width:240px; height: 120px"></textarea><br><br>
		<input type="submit" value="保存笔记"><br>
		
		</form>
		';
    }	

    public function editnote(){
		$nid = $_GET['nid'];
		
		if ($nid < 1) echo '404 Note Not Found!';
		else {
		
			$note = M('notes');
			$note_item = $note->where(' nid='.$nid.' ' )->find();		
			if ($note_item == null) echo '找不到该笔记！';
			else {
				echo "<title>编辑笔记</title>";
				echo '
				<form action="/Note/Admin/savenote?do=edit" method="post">
				<input type="hidden" name="nid" value="'.$note_item['nid'].'">
				标题：<input type="text" name="title" value="'.$note_item['title'].'"><br><br>
				标签：<input type="text" name="tag" value="'.$note_item['tag'].'"><br><br>
				作者：<input type="text" name="author" value="'.$note_item['aid'].'"><br><br>
				时间：<input type="text" name="date" value="'.$note_item['display_date'].'"><br><br>		
				正文：<textarea name="content" style="width:240px; height: 120px">'.$note_item['content'].'</textarea><br><br>
				<input type="submit" value="保存笔记"> <a href="/Note/Index/index">返回目录</a>
				
				</form>
				';	
			}
		}		
		
		

    }

    public function savenote(){
		$data['title'] = $_POST['title'];
		$data['tag'] = $_POST['tag'];
		$data['aid'] = $_POST['author'];
		$data['post_date'] = date('Y-m-d H:i:s');
		$data['display_date'] = date('Y-m-d H:i:s');		
		$data['content'] = $_POST['content'];
		
        $note = M('notes');
		//$note_item = $note->select();		
		
		if ($_GET['do'] == 'edit') { 
		$note->data($data)->where('nid='.$_POST['nid'])->save();
		$callback = $_POST['nid'];
		} else {
			$callback = $note->data($data)->add();
		}
		
		if ($callback == true) echo '笔记保存成功！<a href="/Note/Index/note?nid='.$callback.'">查看笔记</a>，<a href="/Note/Index/index">返回目录</a>';
		
		else echo '笔记保存失败！';
		
    }

    public function delete(){
		$nid = $_GET['nid'];
		
		if ($nid < 1) echo '404 Note Not Found!';
		else {
		
			$note = M('notes');
			$note_item = $note->where(' nid='.$nid.' ' )->find();		
			if ($note_item == null) echo '找不到该笔记！';
			else {
				$callback = $note->where(' nid='.$nid.' ' )->delete();	
				if ($callback == true) echo '记录 #'.$nid.' 删除成功！<br>动作：<a href="/Note/Admin/newnote">新建笔记</a>，<a href="/Note/Index/index">返回目录</a>';
			}
		}		
		
		

    }	
		
}

