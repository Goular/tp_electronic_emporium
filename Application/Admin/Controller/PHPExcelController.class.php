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
     * 使用ExcelPHP输出个性化内容，同时添加样式，背景色，边框等内容
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

    /**
     * 使用PHPExcel添加图片和标注
     */
    public function exportImgsTags()
    {
        require_once './vendor/autoload.php';
        //实例化PHPExcel类，等同于在桌面上新建的一个Excel表格
        $objPHPExcel = new \PHPExcel();
        //获取当前活动的sheet的操作对象
        $objSheet = $objPHPExcel->getActiveSheet();

        /**********插入图片代码开始**********/
        //获得一个图片的操作对象
        $objDrawing = new \PHPExcel_Worksheet_Drawing();
        //加载图片路径
        $objDrawing->setPath("G:/1789.jpg");
        //设置图片插入位置的左上角坐标
        $objDrawing->setCoordinates('F6');
        //设置插入图片的大小
        $objDrawing->setWidth(500);
        $objDrawing->setHeight(100);
        $objDrawing->setOffsetX(20)->setOffsetY(40);//设定单元格内偏移量
        $objDrawing->setWorksheet($objSheet);
        /**代码结束**/

        /************* 添加丰富的文字块 ***********/
        $objRichText = new \PHPExcel_RichText();
        //添加普通的文字 不能操作样式
        $objRichText->createText('裕申电子');
        //生成可以添加样式的文字块
        $objStyleFont = $objRichText->createTextRun("是国内最大的IT技能免费培训平台");
        //加一些样式
        $objStyleFont->getFont()->setSize(16)->setBold(true)->setColor(new \PHPExcel_Style_Color(\PHPExcel_Style_Color::COLOR_GREEN));
        $objRichText->createText('资料各种的丰富');
        $objSheet->getCell('C4')->setValue($objRichText);
        /************* 代码结束 ****************/

        /***************** 添加批注 ******************/
        //合并单元格
        $objSheet->mergeCells('F4:N4');
        //添加批注
        $objSheet->getComment('F4')->getText()->createTextRun("\r\n慕课网\n\n时尚时尚最时尚");
        /*******************代码结束*********************/


        /************************添加超链接代码*************************/
        //添加文字
        $objSheet->setCellValue('I3', '慕课网');
        //添加样式
        $objSheet->getStyle("I3")->getFont()->setSize(16)->setBold(true)->setUnderline(true)->setColor(new \PHPExcel_Style_Color(\PHPExcel_Style_Color::COLOR_BLUE));
        $objSheet->getCell('I3')->getHyperlink()->setUrl("http://www.baidu.com");

        /*************************代码结束********************************/

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');//生成excel文件
        //$objWriter->save($dir."/export_1.xls");//保存文件
        $this->broswer_export('browser_excel03.xlsx');
        $objWriter->save("php://output");
    }


    /**
     * 添加图表到PHPExcel中
     */

    public function exportChart()
    {
        require_once './vendor/autoload.php';
        //实例化PHPExcel类，等同于在桌面上新建的一个Excel表格
        $objPHPExcel = new \PHPExcel();
        //获取当前活动的sheet的操作对象
        $objSheet = $objPHPExcel->getActiveSheet();


        /**本节课程代码编写开始**/
        $array = array(
            array("", "一班", "二班", "三班"),
            array("不及格", 20, 30, 40),
            array("良好", 30, 50, 55),
            array("优秀", 15, 17, 20)
        );//准备数据
        $objSheet->fromArray($array);//直接加载数组填充进单元格内
        //开始图表代码编写
        $labels = array(
            new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', null, 1),//一班
            new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', null, 1),//二班
            new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$1', null, 1),//三班
        );//先取得绘制图表的标签
        $xLabels = array(
            new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$4', null, 3)//取得图表X轴的刻度
        );
        $datas = array(
            new \PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$4', null, 3),//取一班的数据
            new \PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$2:$C$4', null, 3),//取二班的数据
            new \PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$4', null, 3)//取三班的数据
        );//取得绘图所需的数据

        $series = array(
            new \PHPExcel_Chart_DataSeries(
                \PHPExcel_Chart_DataSeries::TYPE_LINECHART,
                \PHPExcel_Chart_DataSeries::GROUPING_STANDARD,
                range(0, count($labels) - 1),
                $labels,
                $xLabels,
                $datas
            )
        );//根据取得的东西做出一个图表的框架
        $layout = new \PHPExcel_Chart_Layout();
        $layout->setShowVal(true);
        $areas = new \PHPExcel_Chart_PlotArea($layout, $series);
        $legend = new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, $layout, false);
        $title = new \PHPExcel_Chart_Title("高一学生成绩分布");
        $ytitle = new \PHPExcel_Chart_Title("value(人数)");
        $chart = new \PHPExcel_Chart(
            'line_chart',
            $title,
            $legend,
            $areas,
            true,
            false,
            null,
            $ytitle
        );//生成一个图标
        $chart->setTopLeftPosition("A7")->setBottomRightPosition("K25");//给定图表所在表格中的位置

        $objSheet->addChart($chart);//将chart添加到表格中


        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');//生成excel文件
        //$objWriter->save($dir."/export_1.xls");//保存文件
        $this->broswer_export('browser_excel031.xlsx', 'Excel2007');
        $objWriter->save("php://output");
    }


    /**
     * 读取Excel文件
     */
    public function readExcel()
    {
        require_once './vendor/autoload.php';
        //实例化PHPExcel类，等同于在桌面上新建的一个Excel表格
        $dir=dirname(__FILE__);//找到当前脚本所在路径
        $filename=$dir."/export_1.xls";
        $fileType=PHPExcel_IOFactory::identify($filename);//自动获取文件的类型提供给phpexcel用
        $objReader=PHPExcel_IOFactory::createReader($fileType);//获取文件读取操作对象
        $sheetName=array("2年级","3年级");
        $objReader->setLoadSheetsOnly($sheetName);//只加载指定的sheet
        $objPHPExcel=$objReader->load($filename);//加载文件
        /**$sheetCount=$objPHPExcel->getSheetCount();//获取excel文件里有多少个sheet
        for($i=0;$i<$sheetCount;$i++){
        $data=$objPHPExcel->getSheet($i)->toArray();//读取每个sheet里的数据 全部放入到数组中
        print_r($data);
        }**/
        foreach($objPHPExcel->getWorksheetIterator() as $sheet){//循环取sheet
            foreach($sheet->getRowIterator() as $row){//逐行处理
                if($row->getRowIndex()<2){
                    continue;
                }
                foreach($row->getCellIterator() as $cell){//逐列读取
                    $data=$cell->getValue();//获取单元格数据
                    echo $data." ";
                }
                echo '<br/>';
            }
            echo '<br/>';
        }
    }
}