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

    /**
     * PHPExcel输出到浏览器内容
     * 在PHPExcel文件夹中含有
     * 01simple-download-xls.php 和
     * 01simple-download-xlsx.php
     * 来处理输出到EXCEL的内容
     */
    public function execBroswer()
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
        $type = 'Excel5';
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, $type);
        $this->broswer_export('62332.xls', $type);

        $type = 'Excel2007';
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, $type);
        $this->broswer_export('62339.xlsx', $type);

        $objWriter->save("php://output");
    }

    //输出Excel到浏览器需要的内容
    private function broswer_export($fileName, $type = 'Excel5')
    {
        //告诉浏览器即将输出的文件的类型
        if ($type == 'Excel5') {
            header('Content-Type: application/vnd.ms-excel');
        } else if ($type == 'Excel2007') {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        }
        //告诉浏览器即将输出文件的名称
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        //禁止缓存
        header('Cache-Control: max-age=0');
    }

    /**
     * 使用ExcelPHP输出个性化内容，同时添加样式，背景色等内容
     */
    public function export_style()
    {
        //加载自动加载的对象
        require_once './vendor/autoload.php';
        $db = null;
        $objPHPExcel = new PHPExcel();//实例化PHPExcel类， 等同于在桌面上新建一个excel
        $objSheet = $objPHPExcel->getActiveSheet();//获得当前活动单元格
        //开始本节课代码编写
        $objSheet->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//设置excel文件默认水平垂直方向居中
        $objSheet->getDefaultStyle()->getFont()->setSize(14)->setName("微软雅黑");//设置默认字体大小和格式
        $objSheet->getStyle("A2:Z2")->getFont()->setSize(20)->setBold(true);//设置第二行字体大小和加粗
        $objSheet->getStyle("A3:Z3")->getFont()->setSize(16)->setBold(true);//设置第三行字体大小和加粗
        $objSheet->getDefaultRowDimension()->setRowHeight(30);//设置默认行高
        $objSheet->getRowDimension(2)->setRowHeight(50);//设置第二行行高
        $objSheet->getRowDimension(3)->setRowHeight(40);//设置第三行行高
        $gradeInfo = $db->getAllGrade();//查询所有的年级
        $index = 0;
        foreach ($gradeInfo as $g_k => $g_v) {
            $gradeIndex = getCells($index * 2);//获取年级信息所在列
            $objSheet->setCellValue($gradeIndex . "2", "高" . $g_v['grade']);
            $classInfo = $db->getClassByGrade($g_v['grade']);//查询每个年级所有的班级
            foreach ($classInfo as $c_k => $c_v) {
                $nameIndex = getCells($index * 2);//获得每个班级学生姓名所在列位置
                $scoreIndex = getCells($index * 2 + 1);//获得每个班级学生分数所在列位置
                $objSheet->mergeCells($nameIndex . "3:" . $scoreIndex . "3");//合并每个班级的单元格
                $objSheet->getStyle($nameIndex . "3:" . $scoreIndex . "3")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6fc144');//填充班级背景颜色
                $classBorder = getBorderStyle("445cc1");//获取班级边框样式代码
                $objSheet->getStyle($nameIndex . "3:" . $scoreIndex . "3")->applyFromArray($classBorder);//设置每个班级的边框
                $info = $db->getDataByClassGrade($c_v['class'], $g_v['grade']);//查询每个班级的学生信息
                $objSheet->setCellValue($nameIndex . "3", $c_v['class'] . "班");//填充班级信息
                $objSheet->getStyle($nameIndex)->getAlignment()->setWrapText(true);//设置文字自动换行
                $objSheet->setCellValue($nameIndex . "4", "姓名\n换行")->setCellValue($scoreIndex . "4", "分数");
                $objSheet->getStyle($scoreIndex)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//设置某列单元格格式为文本格式
                $j = 5;
                foreach ($info as $key => $val) {
                    $objSheet->setCellValue($nameIndex . $j, $val['username'])->setCellValue($scoreIndex . $j, $val['score'] . "21312321321321321321");//填充学生信息
                    //$objSheet->setCellValue($nameIndex.$j,$val['username'])->setCellValueExplicit($scoreIndex.$j,$val['score']."12321321321321312",PHPExcel_Cell_DataType::TYPE_STRING);//填充学生信息
                    $j++;
                }
                $index++;
            }
            $endGradeIndex = getCells($index * 2 - 1);//获得每个年级的终止单元格
            $objSheet->mergeCells($gradeIndex . "2:" . $endGradeIndex . "2");//合并每个年级的单元格
            $objSheet->getStyle($gradeIndex . "2:" . $endGradeIndex . "2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('c1b644');//填充年级背景颜色
            $gradeBorder = getBorderStyle("c144b1");//获取年级边框样式代码
            $objSheet->getStyle($gradeIndex . "2:" . $endGradeIndex . "2")->applyFromArray($gradeBorder);//设置每个年级的边框
        }


        //将数据输出到浏览器
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $this->broswer_export('broswer_excel03.xls');
        $objWriter->save('php://output');
    }

    /**
     * 根据下标获得单元格所在的位置
     */
    private function getCells($index)
    {
        $array = range('A', 'Z');
        return $array[$index];
    }

    /**
     * 获取边框样式代码
     */
    private function getBorderStyle($color)
    {
        return array(
            'borders' => array(
                'outline' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('rgb' => $color)
                )
            )
        );
    }
}