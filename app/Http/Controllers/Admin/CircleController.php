<?php

namespace App\Http\Controllers\Admin;

use App\Helper\CommonHelper;
use App\Helper\ResponseJson;
use App\Models\Circle;
use App\Models\CircleCategory;
use App\Models\Recommend;
use App\Models\SpecialCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CircleController extends Controller
{

    public function categorys(){
        $list = CircleCategory::get();
        return view('admin.circle_category.index',[
            'categories' => $list?$list:[]
        ]);
    }

    /**
     * 添加圈子分类
     * @param Request $request
     */
    public function categorysAdd(Request $request){
        if ($request->isMethod('post')){
            $category_name = trim($request->input('category_name', ''));
            $sort_order = $request->input('sort_order', 0);
            $is_show = $request->input('is_show', 1);
            $img_url = $request->file('img_url', '');
            $description = $request->input('description', '');

            if(empty($category_name)) return ResponseJson::getInstance()->errorJson('分类名称不能为空');
            if (CircleCategory::whereCategoryName($category_name)->exists()) return ResponseJson::getInstance()->errorJson('分类名称已存在');
            if(empty($sort_order)) $sort_order = 0;

            if ($img_url) {
                $img_url = CommonHelper::getInstance()->uploadFile(1,$img_url, 'circle_category/');
            }
            $is_success = CircleCategory::create([
                'category_name'=>$category_name,
                'sort_order'=>$sort_order,
                'img_url'=>$img_url?$img_url:'',
                'description'=>$description?$description:'',
                'is_show'=>$is_show,
            ]);
            if ($is_success) return ResponseJson::getInstance()->doneJson('添加成功');
            return ResponseJson::getInstance()->errorJson('添加失败');
        }
        return view('admin.circle_category.add');
    }

    /**
     * 修改圈子分类
     * @param Request $request
     */
    public function categorysEdit(Request $request, CircleCategory $circleCategory){
        if ($request->isMethod('post')){
            $category_name = $request->input('category_name', '');
            $sort_order = $request->input('sort_order', 0);
            $is_show = $request->input('is_show', 1);
            $img_url = $request->file('img_url', '');
            $description = $request->input('description', '');

            if(empty($category_name)) return ResponseJson::getInstance()->errorJson('分类名称不能为空');
            if(empty($sort_order)) $sort_order = 0;
            if (CircleCategory::whereId('id', '!=', $circleCategory->id)->whereCategoryName($category_name)->exists()){
                return ResponseJson::getInstance()->errorJson('分类名称已存在');
            }
            if ($img_url) {
                $circleCategory->img_url = CommonHelper::getInstance()->uploadFile(1,$img_url, 'circle_category/');
            }
            $circleCategory->category_name = $category_name;
            $circleCategory->sort_order = $sort_order;
            $circleCategory->is_show = $is_show;
            $circleCategory->description = $description?$description:'';
            $circleCategory->save();
            return ResponseJson::getInstance()->doneJson('修改成功');
        }
        return view('admin.circle_category.edit', [
            'category' => $circleCategory
        ]);
    }

    /**
     * 删除分类
     * @param Request $request
     */
    public function categorysDel(Request $request){
        $id = $request->input('id');
        if (empty($id)) return ResponseJson::getInstance()->doneJson('删除成功');
        CircleCategory::whereId($id)->delete();
        return ResponseJson::getInstance()->doneJson('删除成功');
    }

    /**
     * 首页推荐
     */
    public function recommend(){
        $lists = Recommend::whereIsShow(1)->get()->toArray();
        return view('admin.circle_recommend.index', [
            'lists' => $lists
        ]);
    }

    public function searchCircle(Request $request){
        $search = trim($request->input('search', ''));
        if (empty($search)) return ResponseJson::getInstance()->errorJson();
        $lists = Circle::where('title', 'like', "%$search%")->whereType(3)->get();
        return ResponseJson::getInstance()->doneJson('', $lists);

    }

    /**
     * 推荐添加
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function recommendAdd(Request $request){
        if ($request->isMethod('post')) {
            $data['title'] = trim($request->input('title'));
            if (empty($data['title'])) return ResponseJson::getInstance()->errorJson('请填写标题');
            $data['circle_id'] = trim($request->input('circle_id'));
            if (empty($data['circle_id'])) return ResponseJson::getInstance()->errorJson('请选择圈子');
            $data['sort'] = !empty($request->input('sort')) ? trim($request->input('sort')) : 0;
            $data['is_show'] = intval($request->input('is_show'));

            $files = $request->file('img');
            if ($files) {
                if (!$files->isValid()) {
                    return ResponseJson::getInstance()->errorJson('图片不正确');
                }
                $data['cover_img'] = CommonHelper::getInstance()->uploadFile(1,$files, 'recommend/');
            }

            // 读取圈子信息
            $circle = Circle::with('category')->whereId($data['circle_id'])->first()->toArray();
            $data['length'] = $circle['length'];
            $data['video_url'] = $circle['links'];
            $data['categroy_name'] = $circle['category']['category_name'];
            $is_success = Recommend::create($data);
            if ($is_success) {
                return ResponseJson::getInstance()->doneJson('');
            }
            return ResponseJson::getInstance()->errorJson('');
        }

        $lists = Circle::whereType(3)->get();
        return view('admin.circle_recommend.add', [
            'lists' => $lists
        ]);
    }

    /**
     * 推荐修改
     * @param Request $request
     * @param Recommend $circleRecommend
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function recommendEdit(Request $request, Recommend $circleRecommend){
        if ($request->isMethod('post')) {

            $circleRecommend->title = trim($request->input('title'));
            if (empty($circleRecommend['title'])) return ResponseJson::getInstance()->errorJson('请填写标题');
            $circleRecommend->circle_id = trim($request->input('circle_id'));
            if (empty($circleRecommend['circle_id'])) return ResponseJson::getInstance()->errorJson('请选择圈子');
            $circleRecommend->sort = !empty($request->input('sort')) ? trim($request->input('sort')) : 0;
            $circleRecommend->is_show = intval($request->input('is_show'));

            $files = $request->file('img');
            if ($files) {
                if (!$files->isValid()) {
                    return ResponseJson::getInstance()->errorJson('图片不正确');
                }
                $circleRecommend->cover_img = CommonHelper::getInstance()->uploadFile(1,$files, 'recommend/');
            }

            // 读取圈子信息
            $circle = Circle::with('category')->whereId($circleRecommend->circle_id)->first()->toArray();
            $circleRecommend->length = $circle['length'];
            $circleRecommend->video_url = $circle['links'];
            $circleRecommend->categroy_name = $circle['category']['category_name'];
            $is_success = $circleRecommend->update();
            if ($is_success) {
                return ResponseJson::getInstance()->doneJson('');
            }
            return ResponseJson::getInstance()->errorJson('');
        }
        $lists = Circle::whereType(3)->get();
        return view('admin.circle_recommend.edit', [
            'lists' => $lists,
            'data' => $circleRecommend->toArray(),
        ]);
    }

    public function recommendDel(){

        return view('admin.circle_recommend.edit');
    }


}
