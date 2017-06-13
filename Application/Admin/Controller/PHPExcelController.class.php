<?php
namespace Admin\Controller;

use Think\Controller;

class PHPExcelController extends Controller
{
    /**
     * PHPExcel的简单使用
     */
    public function exec()
    {
        require_once './vendor/autoload.php';
        //实例化PHPExcel类，等同于在桌面上新建的一个Excel表格
        $objPHPExcel = new \PHPExcel();
        //获取当前活动的sheet的操作对象
        $objSheet = $objPHPExcel->getActiveSheet();
        //设定当前sheet的名称
        $objSheet->setTitle('测试表格的Sheet01');

        //添加数据[方法有两种，建议使用方法一，原因是数组的方式，在excel对象太大时数组容易崩溃，执行时间过长30s左右时，会变为无数据返回的现象]

        //方法一: setValue(sheet的位置,显示的文本内容)
//        $objSheet->setCellValue('A1', '姓名')->setCellValue('B1', '分数');
//        $objSheet->setCellValue('A2', '张三')->setCellValue('B2', '61');
//        $objSheet->setCellValue('A3', '李四')->setCellValue('B3', '92');

        //方法二:数组添加daosheet中,每一行都是二维数组的内容
        $array = array(
            array(),//空出第一行的内容
            array('', '姓名', '分数'),//空出第一列
            array('', '王维', '87'),
            array('', '赵申', '63')
        );
        $objSheet->fromArray($array);

        //按照指定格式生成Excel文件 [第二个参数为excel格式:Excel5为excel2003，Excel2007为excel2007]
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $savePath = __DIR__ . '/demo02.xlsx';
        $objWriter->save($savePath);
    }

    /**
     * PHPExcel连接数据库的使用
     */
    public function exec2()
    {
        //加载自动加载的对象
        require_once './vendor/autoload.php';
        $goodsModel = D('goods');
        $data = $goodsModel->select();
        //formatVarDump($data);
        //相当在桌面新建一个Excel
        $objPHPExcel = new \PHPExcel();
        for ($i = 1; $i <= 3; $i++) {
            if ($i > 1) {
                //创建新的内置表
                $objPHPExcel->createSheet();
            }
            //新建sheet并设定为当前文件为活动sheet
            $objPHPExcel->setActiveSheetIndex($i - 1);
            //获取当前活动sheet
            $objSheet = $objPHPExcel->getActiveSheet();
            $objSheet->setTitle("班级{$i}的表格");
            $objSheet->setCellValue('A1', '商品名称')->setCellValue('B1', '市场价格')->setCellValue('C1', '本店价格');
            $row = 2;//设定数据显示的首行，不然会错误，或者是覆盖
            foreach ($data as $key => $value) {
                $objSheet->setCellValue("A" . $row, $value['goods_name'])->setCellValue("B" . $row, $value['market_price'])->setCellValue('C' . $row, $value['show_price']);
                $row++;
            }
        }
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $savePath = __DIR__ . '/mysql.xls';
        $objWriter->save($savePath);
    }
}