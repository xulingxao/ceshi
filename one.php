public function one()
    {
        $arr = [
            ['id' => 1, 'name' => '大师', 'master_id' => 0],
            ['id' => 2, 'name' => '剑术大弟子', 'master_id' => 1],
            ['id' => 3, 'name' => '刀术大弟子', 'master_id' => 1],
            ['id' => 4, 'name' => '幻术大弟子', 'master_id' => 1],
            ['id' => 5, 'name' => '门徒5', 'master_id' => 3],
            ['id' => 6, 'name' => '门徒6', 'master_id' => 2],
            ['id' => 7, 'name' => '门徒7', 'master_id' => 2],
            ['id' => 8, 'name' => '门徒8', 'master_id' => 4],
            ['id' => 9, 'name' => '门徒9', 'master_id' => 5],
            ['id' => 10, 'name' => '门徒10', 'master_id' => 6],
            ['id' => 11, 'name' => '门徒11', 'master_id' => 9],
            ['id' => 12, 'name' => '门徒12', 'master_id' => 11],
            ['id' => 13, 'name' => '门徒13', 'master_id' => 8],
            ['id' => 14, 'name' => '门徒14', 'master_id' => 8],
            ['id' => 15, 'name' => '门徒15', 'master_id' => 12],
            ['id' => 16, 'name' => '门徒16', 'master_id' => 10],
            ['id' => 17, 'name' => '门徒17', 'master_id' => 15],
            ['id' => 18, 'name' => '门徒18', 'master_id' => 7],
            ['id' => 19, 'name' => '门徒19', 'master_id' => 17],
            ['id' => 20, 'name' => '门徒20', 'master_id' => 18],
        ];

        $arr2 = array();
        foreach ($arr as $value){
            if ($value['master_id'] == 1){
                $arr2[$value['id']] = $this->getTree($arr,$value['id'],0,true);
            }
        }
        $array3 = $this->getTree($arr,0,0,true);
        foreach ($array3 as $key => $value){
            if (isset($arr2[$value['id']])){
                $array3[$key]['name'] = $value['name']."(".count($arr2[$value['id']]).")";
            }
        }
        foreach ($array3 as $value) {
            echo str_repeat('--', $value['level']), $value['name'] . '<br />';
        }
    }
    
  
    function getTree($array, $pid = 0, $level = 0,$status = false)
    {

        //声明静态数组,避免递归调用时,多次声明导致数组覆盖
        static $list = [];
        if ($status){
            $list = array();
        }
        foreach ($array as $key => $value) {
            //第一次遍历,找到父节点为根节点的节点 也就是pid=0的节点
            if ($value['master_id'] == $pid) {
                //父节点为根节点的节点,级别为0，也就是第一级
                $value['level'] = $level;
                //把数组放到list中
                $list[] = $value;
                //把这个节点从数组中移除,减少后续递归消耗
                unset($array[$key]);
                //开始递归,查找父ID为该节点ID的节点,级别则为原级别+1
                $this->getTree($array, $value['id'], $level + 1);
            }
        }
        return $list;
    }
