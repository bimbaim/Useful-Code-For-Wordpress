<?php

/********* Export to xlsx ***********/
add_action('admin_footer', 'mytheme_export_users');
 
function mytheme_export_users() {
    $screen = get_current_screen();
    if ( $screen->id != "users" )   // Only add to users.php page
        return;
    ?>
    <script type="text/javascript">
        jQuery(document).ready( function($)
        {
            $('.tablenav.top .clear, .tablenav.bottom .clear').before('<form action="#" method="POST"><input type="hidden" id="mytheme_export_xlsx" name="mytheme_export_xlsx" value="1" /><input class="button button-primary user_export_button" style="margin-top:3px;" type="submit" value="<?php esc_attr_e('Export All as XLSX', 'mytheme');?>" /></form>');
        });
    </script>
    <?php
}
 
add_action('admin_init', 'export_xlsx'); //you can use admin_init as well
 
function export_xlsx() {
    if (!empty($_POST['mytheme_export_xlsx'])) {
 
        if (current_user_can('manage_options')) {
 
            /** PHPExcel */
			include 'PHPExcel.php';
 
			/** PHPExcel_Writer_Excel2007 */
			include 'PHPExcel/Writer/Excel2007.php';
 
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
 
			// Set properties
			$objPHPExcel->getProperties()->setTitle( esc_html__('Test xlsx document', 'mytheme') );
			$objPHPExcel->getProperties()->setSubject( esc_html__('Test xlsx document', 'mytheme') );
			$objPHPExcel->getProperties()->setDescription( esc_html__('Test export users document for XLSX, generated using PHP classes.', 'mytheme') );
 
			// WP_User_Query arguments
            $args = array (
                'order'   => 'ASC',
                'orderby' => 'display_name',
                'fields'  => 'all',
            );
 
            // The User Query
            $blogusers = get_users( $args );
            $cell_counter = 1;
 
            //Set up the labels of the columns
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', esc_html__('First Name', 'mytheme'));
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', esc_html__('Last Name', 'mytheme'));
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', esc_html__('Email', 'mytheme'));
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', esc_html__('User Role', 'mytheme'));
 
            foreach ( $blogusers as $user ) {
                $cell_counter++;
 
                $meta = get_user_meta($user->ID);
                $role = $user->roles;
                $email = $user->user_email;
 
                $first_name = ( isset($meta['first_name'][0]) && $meta['first_name'][0] != '' ) ? $meta['first_name'][0] : '' ;
                $last_name  = ( isset($meta['last_name'][0]) && $meta['last_name'][0] != '' ) ? $meta['last_name'][0] : '' ;
 
				// Add data
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$cell_counter.'', $first_name);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$cell_counter.'', $last_name);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$cell_counter.'', $email);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$cell_counter.'', ucfirst($role[0]));
 
            }
 
            // Set column data auto width
            for($col = 'A'; $col !== 'E'; $col++) {
			    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
			}
 
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle(esc_html__('Users', 'mytheme'));
 
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="users.xlsx"');
			header('Cache-Control: max-age=0');
 
			// Save Excel file
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
 
			exit();
        }
    }
}
