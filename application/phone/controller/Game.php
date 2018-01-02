<?php
namespace app\phone\controller;

use think\Controller;
class Game extends Controller{
    public function game(){
        $id=input('id');

            $where=[
                'name'=>$id
            ];
            db("game")->insert($where);
            $data=[
                'HP'=>40,
            ];
     echo json_encode($data);

    }
    public function gamelogin(){
        $id=[
            'id'=>input('id'),
            'name'=>input('name'),
            'phone'=>input('phone'),
            ];
        if($id['id']==0 || !$id['id']){
            $myboss=[
                'hp'=>200,
                'uid'=>1,
            ];
            $id=db('a_game_boss')->insertGetId($myboss);
            $data = [
                'name' => input('name'),
                'phone' => input('phone'),
                'pid' =>$id,
            ];
            db('a_game_name')->insert($data);
        }else {
            echo 1;
            $myuid=db('a_game_boss')->where('id',$id['id'])->find();
            if($myuid['uid']==3){
                $this->redirect('http://www.fmtoa.com/game/index.html?id=0');
            }else {
                $where=[
                    'id'=>$id['id'],
                    'uid'=>$myuid['uid']+1,
                ];
                db('a_game_boss')->update($where);
                $data = [
                    'name' => $id['name'],
                    'phone' =>$id['phone'],
                    'pid' => $id['id'],
                ];
                db('a_game_name')->insert($data);
            }
        }
    }
}