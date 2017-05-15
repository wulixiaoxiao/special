<?php

namespace App\Http\Controllers\Admin;

use App\Helper\CommonHelper;
use App\Helper\ResponseJson;
use App\Library\AliOss;
use App\Models\CircleCategory;
use App\Models\Goods;
use App\Models\Special;
use App\Models\SpecialCategory;
use App\Models\SpecialContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use OSS\OssClient;

class SpecialController extends Controller
{

    public function index(){
        $lists = Special::orderBy('sort_order')->get();
        return view('admin.special.index', [
            'lists' => $lists
        ]);
    }

    public function add(Request $request){

        if ($request->isMethod('post')) {
            $inputData = [];
            for ($i = 0; $i < count($request->input('type')); $i++){
                $inputData[$i]['type'] = $request->input('type')[$i];
                $inputData[$i]['sort'] = $request->input('sort')[$i];
                $inputData[$i]['content'] = $request->input('content')[$i];
                //上传文件
                if (isset($request->file('videofile')[$i])) {
                    $filePath = CommonHelper::getInstance()->uploadFile($inputData[$i]['type'], $request->file('videofile')[$i], 'special/');
                }else{
                    $filePath = '';
                }
                $inputData[$i]['filePath'] = isset($filePath)?$filePath:'';
            }

            $data['title'] = $request->input('title');
            if (!$data['title']) return ResponseJson::getInstance()->errorJson('标题不能为空');

            $data['subtitle'] = $request->input('subtitle');
            if (!$data['subtitle']) return ResponseJson::getInstance()->errorJson('副标题不能为空');

            $data['description'] = $request->input('description');
            if (!$data['description']) return ResponseJson::getInstance()->errorJson('专题描述不能为空');

            $data['sort_order'] = $request->input('sort_order')?$request->input('sort_order'):0;
            $data['category_id'] = $request->input('category_id');
            $data['is_recommend'] = $request->input('is_recommend');
            $request->input('goods') && $data['goodids'] = implode(',', $request->input('goods'));

            $specialInfo = Special::create($data);
            if($specialInfo){
                foreach ($inputData as $v){
                    SpecialContent::create([
                        'special_id' => $specialInfo->id,
                        'type' => $v['type'],
                        'sort' => $v['sort']?$v['sort']:0,
                        'content' => $v['content']?$v['content']:'',
                        'filePath' => $v['filePath']?$v['filePath']:'',
                    ]);
                }
                return ResponseJson::getInstance()->doneJson('添加成功');
            }
            return ResponseJson::getInstance()->errorJson('添加失败');
        }

        $categories = SpecialCategory::get()->toArray();
        return view('admin.special.add', [
            'categories' => $categories
        ]);
    }

    public function delSpecialContent(Request $request){
        $id = $request->input('id');
        if (!$id) return ResponseJson::getInstance()->errorJson('非法操作');
        $specContent = SpecialContent::whereId($id)->first();
        if ($specContent) {
            $is_success = $specContent->delete();

            return ResponseJson::getInstance()->doneJson('', ['data'=>1]);
        }
        return ResponseJson::getInstance()->doneJson('', ['data'=>0]);
    }

    /**
     * 编辑专题
     */
    public function edit(Request $request, Special $special){
        if ($request->isMethod('post')) {

            $special->title = $request->input('title');
            $special->subtitle = $request->input('subtitle');
            $special->description = $request->input('description')?$request->input('description'):'';
            $special->sort_order = $request->input('sort_order')?$request->input('sort_order'):0;
            $special->category_id = $request->input('category_id');
            $special->is_recommend = $request->input('is_recommend');
            $request->input('goods') && $special->goodids = implode(',', $request->input('goods'));
            $is_success = $special->save();
            if($is_success){
                $inputData = [];
                if (count($request->input('type')) >= 1) {
                    foreach (array_keys($request->input('type')) as $i){
                        if (in_array($i, $request->input('id'))) {
                            $inputData[$i]['id'] = $i;
                            if(!empty($request->file('videofile')[$i])) {
                                $filePath = CommonHelper::getInstance()->uploadFile($request->input('type')[$i], $request->file('videofile')[$i], 'special/');
                                $inputData[$i]['filePath'] = $filePath;
                            }
                        }else{
                            $inputData[$i]['id'] = -1;
                            $filePath = CommonHelper::getInstance()->uploadFile($request->input('type')[$i], $request->file('videofile')[$i], 'special/');
                            $inputData[$i]['filePath'] = $filePath;
                        }
                        $inputData[$i]['type'] = $request->input('type')[$i];
                        $inputData[$i]['sort'] = $request->input('sort')[$i];
                        $inputData[$i]['content'] = $request->input('content')[$i];

                    }
                    foreach ($inputData as $v){
                        $specialCon = SpecialContent::whereId($v['id'])->first();
                        if(isset($specialCon) && $specialCon->id){
                            $updateData['type'] = $v['type'];
                            $updateData['sort'] = $v['sort'];
                            $updateData['content'] = $v['content'];
                            isset($v['filePath'])&&!empty($v['filePath'])?$updateData['filePath'] = $v['filePath']:'';
                            SpecialContent::whereId($v['id'])->update($updateData);
                        }else{
                            SpecialContent::create([
                                'special_id' => $special->id,
                                'type' => $v['type'],
                                'sort' => $v['sort']?$v['sort']:0,
                                'content' => $v['content'],
                                'filePath' => $v['filePath'],
                            ]);
                        }
                    }
                }
                return ResponseJson::getInstance()->doneJson('修改成功');
            }
            return ResponseJson::getInstance()->errorJson('修改失败');
        }

        $specialContents = SpecialContent::whereSpecialId($special->id)->get()->toArray();
        foreach ($specialContents as $k=>$v){
            $specialContents[$k]['filePath'] = CommonHelper::getInstance()->getOssPath($v['filePath']);
        }
        $lastId = SpecialContent::whereSpecialId($special->id)->orderBy('id', 'desc')->first();
        $categories = SpecialCategory::get()->toArray();

        $selGoods = Goods::whereIsOnline(1)->select(['id', 'goods_name'])->whereIn('id', explode(',', $special->goodids))->get()->toArray();

        return view('admin.special.edit', [
            'special' => $special,
            'categories' => $categories,
            'specialContents' => $specialContents,
            'selGoods' => $selGoods,
            'lastId' => $lastId?$lastId->id:0
        ]);
    }

    /**
     * 删除专题
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del(Request $request){
        $id = $request->input('id');
        $is_success = Special::whereId($id)->delete();
        //TODO 删除点赞评论等
        if ($is_success) return ResponseJson::getInstance()->doneJson('删除成功');
        return ResponseJson::getInstance()->errorJson('删除失败');
    }

    /**
     * 获取专题分类
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categorys(){
        $list = SpecialCategory::get();
        return view('admin.special_category.index',[
            'categories' => $list?$list:[]
        ]);
    }

    /**
     * 添加专题分类
     * @param Request $request
     */
    public function categorysAdd(Request $request){
        if ($request->isMethod('post')){
            $category_name = $request->input('category_name', '');
            $sort_order = $request->input('sort_order', 0);
            $is_show = $request->input('is_show', 1);

            if(empty($category_name)) return ResponseJson::getInstance()->errorJson('分类名称不能为空');
            if(empty($sort_order)) $sort_order = 0;

            $is_success = SpecialCategory::create([
                'category_name'=>$category_name,
                'sort_order'=>$sort_order,
                'is_show'=>$is_show,
            ]);
            if ($is_success) return ResponseJson::getInstance()->doneJson('添加成功');
            return ResponseJson::getInstance()->errorJson('添加失败');
        }
        return view('admin.special_category.add');
    }

    /**
     * 修改专题分类
     * @param Request $request
     */
    public function categorysEdit(Request $request, SpecialCategory $specialCategory){
        if ($request->isMethod('post')){
            $category_name = $request->input('category_name', '');
            $sort_order = $request->input('sort_order', 0);
            $is_show = $request->input('is_show', 1);

            if(empty($category_name)) return ResponseJson::getInstance()->errorJson('分类名称不能为空');
            if(empty($sort_order)) $sort_order = 0;
            if (SpecialCategory::whereId('id', '!=', $specialCategory->id)->whereCategoryName($category_name)->exists()){
                return ResponseJson::getInstance()->errorJson('分类名称已存在');
            }

            $specialCategory->category_name = $category_name;
            $specialCategory->sort_order = $sort_order;
            $specialCategory->is_show = $is_show;
            $specialCategory->save();
            return ResponseJson::getInstance()->doneJson('修改成功');
        }
        return view('admin.special_category.edit', [
            'category' => $specialCategory
        ]);
    }

    /**
     * 删除分类
     * @param Request $request
     */
    public function categorysDel(Request $request){
        $id = $request->input('id');
        if (empty($id)) return ResponseJson::getInstance()->doneJson('删除成功');
        SpecialCategory::whereId($id)->delete();
        return ResponseJson::getInstance()->doneJson('删除成功');
    }

}
