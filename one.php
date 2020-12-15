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

        //根据父节点，给数组重新排序。
        $array3 = $this->getTree($arr,0,0,true);


        // 结果：
         array:20 [▼
          0 => array:4 [▼
            "id" => 1
            "name" => "大师"
            "master_id" => 0
            "level" => 0
          ]
          1 => array:4 [▼
            "id" => 2
            "name" => "剑术大弟子"
            "master_id" => 1
            "level" => 1
          ]
          2 => array:4 [▼
            "id" => 6
            "name" => "门徒6"
            "master_id" => 2
            "level" => 2
          ]
          3 => array:4 [▶]
          4 => array:4 [▶]
          5 => array:4 [▶]
          6 => array:4 [▶]
          7 => array:4 [▶]
          8 => array:4 [▶]
          9 => array:4 [▶]
          10 => array:4 [▶]
          11 => array:4 [▶]
          12 => array:4 [▶]
          13 => array:4 [▶]
          14 => array:4 [▶]
          15 => array:4 [▶]
          16 => array:4 [▶]
          17 => array:4 [▶]
          18 => array:4 [▶]
          19 => array:4 [▶]

        $arr2 = array();
        //找到父节点为大师的节点 也就是master_id=1的节点(找到所有大弟子)
        foreach ($arr as $value){
            if ($value['master_id'] == 1){
                //找到大弟子下的所有子节点，并将大弟子的id作为索引值
                $arr2[$value['id']] = $this->getTree($arr,$value['id'],0,true);
            }
        }
       // 结果：
        array:3 [▼
          2 => array:6 [▼
            0 => array:4 [▶]
            1 => array:4 [▶]
            2 => array:4 [▶]
            3 => array:4 [▶]
            4 => array:4 [▶]
            5 => array:4 [▶]
          ]
          3 => array:7 [▼
            0 => array:4 [▶]
            1 => array:4 [▶]
            2 => array:4 [▶]
            3 => array:4 [▶]
            4 => array:4 [▶]
            5 => array:4 [▶]
            6 => array:4 [▶]
          ]
          4 => array:3 [▼
            0 => array:4 [▶]
            1 => array:4 [▶]
            2 => array:4 [▶]
          ]



        //将弟子数量与大弟子对应
        foreach ($array3 as $key => $value){
            //若id与在arr2中找到索引，拼接字符串。
            if (isset($arr2[$value['id']])){
                $array3[$key]['name'] = $value['name']."(".count($arr2[$value['id']]).")";
            }
        }

        //根据层级，将字符串‘--’重复。
        foreach ($array3 as $value) {
            echo str_repeat('--', $value['level']), $value['name'] . '<br />';
        }
    }
    


    /**
     * $array 数组数据
     * $pid 根节点
     * $level 层级
     * $status 是否需要数组初始化
     **/
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
