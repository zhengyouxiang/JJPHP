<?php
class ApplicationModel extends Model
{
	public function getDetailById($id)
	{
		if(!is_numeric($id)) return null;
		return $this->orm->application[$id]->getRow();
	}
	public function tostring()
	{
		$r=array();
		foreach ($this->orm->application() as $application) {
			$r[]=(string) $application;
		}
		return $r;
	}
	/**
	 SELECT application.* FROM application WHERE ((maintainer_id) IS NOT NULL AND maintainer_id IS NULL)
	 SELECT application.* FROM application WHERE (maintainer_id IN (11))
	 SELECT application.* FROM application WHERE (NOT maintainer_id IN (11))
	 SELECT application.* FROM application WHERE ((NOT maintainer_id) IS NOT NULL AND NOT maintainer_id IS NULL)
	 */
	public function wherein()
	{

		$r=array();
		$r[]=$this->orm->application("maintainer_id", array()) ->count("*") ;
		$r[]=$this->orm->application("maintainer_id", array(11)) ->count("*") ;
		$r[]=$this->orm->application("NOT maintainer_id", array(11)) ->count("*") ;
		$r[]= $this->orm->application("NOT maintainer_id", array()) ->count("*") ;
		return $r;
	}
	public function where()
	{

		$r=array();
		$software=$this->orm;
		foreach (array(
		$software->application("id", 4),
		$software->application("id < ?", 4),
		$software->application("id < ?", array(4)),
		$software->application("id", array(1, 2)),
		$software->application("id", null),
		$software->application("id", $software->application()),
		$software->application("id < ?", 4)->where("maintainer_id IS NOT NULL"),
		$software->application(array("id < ?" => 4, "author_id" => 12)),
		) as $result) {
			echo
			$r[]= implode(", ", array_keys(iterator_to_array($result->order("id"))));
		}
		return $r;
	}
	/**
	 * limit(3,0)
	 * 3表示取3条  0表示从第一开始
	 * SELECT application.* FROM application   ORDER BY id LIMIT 3 OFFSET 0
	 */
	public function limit()
	{
		return  $this->orm->application()->limit(3,0)->order('id')->fetchAllData();
	}
	/**
	 * SELECT application.* FROM application WHERE (web LIKE ?) ORDER BY title LIMIT 3 OFFSET 0
	 */
	public function searchOrder()
	{
		return $this->orm->application("web LIKE ?", "http://%")->order("title")->fetchAllData();
	}
	/**
	 * 外键
	 */
	public function basic()
	{
		$r=array();
		$software=$this->orm;
		$i=0;
		foreach ($software->application() as $application) {
			$temp=array();
			// $application->author["name"] application为外表 author 主表 application 里 author_id
			$r[$i]['apptitle']=$application[title];
			$r[$i]['authorname']=$application->author["name"];
			foreach ($application->application_tag() as $application_tag) {	//application主表  application_tag外表
				$temp[]= $application_tag->tag["name"];//application_tag 外表 tag主表
			}
			$r[$i]['tagname']=$temp;
			$i++;
		}
		return $r;
	}
	public function findone()
	{
		$r=array();
		$software=$this->orm;
		$application = $software->application("title", "Adminer")->fetch();//Row
		foreach ($application->application_tag("tag_id", 21) as $application_tag) {//$application->application_tag("tag_id", 21) Result
			$r[]= $application_tag->tag["name"];
		}
		return $r;
	}
	public function aggregation()
	{
		$r=array();
		$software=$this->orm;
		foreach ($software->application() as $application) {

			$count = $application->application_tag()->count("*");
			$r[]= "$application[title]: $count tag(s)";
		}
		return $r;
	}
	public function fetchPairs()
	{

		$software=$this->orm;
		return $software->application()->order("title")->fetchPairs("id", "title");
	}
	public function union()
	{
		$r=array();

		$applications = $software->application()->select("id");
		$tags = $software->tag()->select("id");
		foreach ($applications->union($tags)->order("id DESC") as $row) {
			$r[]=$row['id'];
		}
		return $r;
	}
	public function  inMulti()
	{
		$r=array();
		$software=$this->orm;
		foreach ($software->author()->order("id") as $author) {
			foreach ($software->application_tag("application_id", $author->application())->order("application_id, tag_id") as $application_tag) {
				$r[]= "$author: $application_tag[application_id]: $application_tag[tag_id]";
			}
		}
		return $r;
	}
	public function arrayOffset()
	{
		$software=$this->orm;
		return $software->application[array("title" => "Adminer")]["id"];
	}
	public function multipleArguments()
	{
		$r=array();
		$software=$this->orm;
		$application = $software->application[1];
		foreach ($application->application_tag()
		->select("application_id", "tag_id")
		->order("application_id DESC", "tag_id DESC")
		as $application_tag) {
			$r[]= "$application_tag[application_id] $application_tag[tag_id]";
		}
		return $r;
	}
	public function update()
	{
		$software=$this->orm;
		$application = $software->application()->insert(array(
	"id"=>5,
	"author_id" => $software->author[12],
	"title" =>'Texy',
	"web" => "",
	"slogan" => "The best humane Web text generator",
		));
		$application_tag = $application->application_tag()->insert(array("tag_id" => 21));
		$application["web"] = "http://texy.info/";
		$application->update() ;
		$application= $software->application[5];
		$software->application_tag("application_id", 5)->delete();
		$application->delete() ;
	}
	public function rowset()
	{
		$software=$this->orm;
		$application = $software->application[1];
		$application->author = $software->author[12];
		$application->update();
		$application->update(array("author_id" => 11));
	}
	public function insertUpdate()
	{
		$software=$this->orm;
		for ($i=0; $i < 2; $i++) {
			$software->application()->insert_update(array("id" => 5), array("author_id" => 12, "title" => "Texy", "web" => "", "slogan" => "$i")) ;
		}
		$application = $software->application[5];
		$application->application_tag()->insert_update(array("tag_id" => 21), array());
		$software->application("id", 5)->delete();
	}
	public function join()
	{
		$software=$this->orm;
		return  $software->application()->join('author','application.author_id=author.id')->select('*, author.id as authorid')->fetchAllData();
	}
	public function sqlexec()
	{
		$this->orm->JJDAO->beginTransaction();
		$sql="INSERT INTO  `application` (`id` ,`author_id` ,`maintainer_id` ,`title` ,`web` ,`slogan`)VALUES (NULL ,  '11', NULL ,  'test',  '',  '')";
	$this->orm->JJDAO->exec($sql);
		$this->orm->JJDAO->rollback();
	}
	public function sqlquery()
	{
		$sql="select * from application";
		return $this->orm->JJDAO->query($sql);
	}
}

