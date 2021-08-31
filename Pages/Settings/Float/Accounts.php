<?php

require_once  DTWP_DIR_path.'Classes/DBactions.php';
$current_url = '?page=DTWP_settings&tab=Float&sT=Accounts';
if(isset($_GET['Delete'])){
    DTWP_DBactions::Delete($_GET['Delete'],'DTWP_Accounts_',$current_url);
}
if(isset($_POST['submit'])){
    $getEditId = ( isset( $_GET['Edit'] ) ) ? $_GET['Edit'] : '';
    DTWP_DBactions::Update($_POST,sanitize_text_field($getEditId),'DTWP_Accounts_',$current_url);
}

//Edit Account
if(isset($_GET['Edit'])){
   $Accounts_edit = get_option($_GET['Edit']); 
}

//Get this page options
$Accounts_info = get_option('DTWP_Accounts_list');
?>

<table class="form-table dtwp-form-table Accounts">
    <tr>
        <th scope="row">
        <img src="<?php echo  esc_url(isset($_GET['Edit']) ? $Accounts_edit['img-ACS'] : DTWP_image.'users/user(15).png'); ?>" id="img-src">
        <input type="hidden" name="img-ACS"  id="img-ACS" value="<?php echo  isset($_GET['Edit']) ? esc_attr($Accounts_edit['img-ACS']) : DTWP_image.'users/user(15).png'; ?>">
        
        <div class="DTWP_userImg_list">
            <?php
                //include media library
                wp_enqueue_media();
            ?>
            <img id="img-upload"  class="dtwp-icon dtwp-upload" src="<?php echo DTWP_image; ?>Upload.png" >
            <?php
            for($i=1;$i<=15;$i++){ $floatIcon = DTWP_image."users/user($i).png"; ?>
                <img class="dtwp-users " src="<?php echo  esc_url($floatIcon); ?>" >
            <?php } ?>
        </div>
        </th>
        <td class="dtwp-Account-info">
            <label for="Account-name"><?php esc_html_e('Full name','DTWPLANG'); ?></label>
            <input type="text" name="Account-name" value="<?php echo  isset($_GET['Edit']) ? esc_attr( $Accounts_edit['Account-name'] ) : ''; ?>" >
            <br>
            <label for="Account-title"><?php esc_html_e('Title','DTWPLANG'); ?></label>
            <input type="text" name="Account-title" value="<?php echo  isset($_GET['Edit']) ? esc_attr( $Accounts_edit['Account-title']  ): ''; ?>" >
            <br>
            <label for="Account-availableFrom"><?php esc_html_e('Available from','DTWPLANG'); ?></label>
            <input type="time" name="Account-availableFrom" value="<?php echo  isset($_GET['Edit']) ? esc_attr( $Accounts_edit['Account-availableFrom'] ) : '' ; ?>" >
            <br>
            <label for="Account-availableTo"><?php esc_html_e('To','DTWPLANG'); ?></label>
            <input type="time" name="Account-availableTo" value="<?php echo   isset($_GET['Edit']) ? esc_attr( $Accounts_edit['Account-availableTo'] ) : '' ; ?>" >
            <br>
            <label ><?php esc_html_e('Country code','DTWPLANG'); ?></label>
            <select name="Country_Code" id="Country_Code" required><?php require_once DTWP_DIR_path.'Assets/Country_code.php'; ?></select>
            <br>
            <label for="Account-whatsapp-number"><?php esc_html_e('Whatsapp number','DTWPLANG'); ?></label>
            <input type="number" value="<?php echo   isset($_GET['Edit']) ? esc_attr( $Accounts_edit['Account-whatsapp-number'] ) : '' ; ?>" name="Account-whatsapp-number" id="Account-whatsapp-number"  required>
            <br>
            <label for="DefaultText"><?php esc_html_e('Text','DTWPLANG'); ?></label>
            <textarea id="DefaultText" name="DefaultText"></textarea>
            <button type="submit" name="submit" class="button button-primary" value="Accounts"><?php isset($_GET['Edit'])? esc_html_e('Save','DTWPLANG') : esc_html_e('Insert','DTWPLANG'); ?></button>
            <br>
            <a href="?page=DTWP_settings&tab=Float&sT=Accounts" class="button button-small new-ACS-btn" style="<?php echo  isset($_GET['Edit']) ? '' : 'display:none;' ?>"><?php esc_html_e('New','DTWPLANG'); ?></a>

        </td>
    </tr>
   
</table>

    <?php
    if(!empty($Accounts_info)){
        echo "<table class='form-table dtwp-form-table Accounts Accounts-view'>";
        foreach($Accounts_info as $Account){
            
            $ACSInfo = get_option($Account);
            $availableTime = __('Available from','DTWPLANG').' '. $ACSInfo['Account-availableFrom'] .' '.__('To','DTWPLANG').' '.$ACSInfo['Account-availableTo'];
            
            echo "<tr><th scope='row'><img src='".esc_url($ACSInfo['img-ACS'])."'></th>";
            echo "<td class='dtwp-Account-info-view'>";
                    echo "<div>".esc_html($ACSInfo['Account-name'])."</div>";
                    echo "<div>".esc_html($ACSInfo['Account-title'])."</div>";
                ?><div>
                    <?php !empty($ACSInfo['Account-availableFrom'])? esc_html_e($availableTime) : ''; ?>
                </div>
                <?php
                    echo "<div>".esc_html($ACSInfo['Country_Code'].$ACSInfo['Account-whatsapp-number'])."</div>";
                    echo "<div>".esc_html($ACSInfo['DefaultText'])."</div>";
                    echo "<div><a href='?page=DTWP_settings&tab=Float&sT=Accounts&Edit=$Account'>".__('Edit','DTWPLANG')."</a>
                    <a href='?page=DTWP_settings&tab=Float&sT=Accounts&Delete=$Account'>".__('Delete','DTWPLANG')."</a>";
                echo "</div></td></tr>";
            
        }
        echo "</table>";
    }
        ?>
        

<script>
    jQuery(document).ready(function($){
       $('#img-upload').click(function(e){
            e.preventDefault();
            var upload = wp.media({
                multiple:false
            }).on('select', function(){
                var select = upload.state().get('selection');
                var attach = select.first().toJSON();
                $('#img-ACS').attr('value',attach.url);
                $('#img-src').attr('src',attach.url);
            })
            .open();
       });
       
       $('.dtwp-users').click(function(){
            $('#img-ACS').attr('value',$(this).attr('src'));
            $('#img-src').attr('src',$(this).attr('src'));             
       });
       
    });
    
    <?php
    if(isset($_GET['Edit'])){ ?>
        document.getElementById('Country_Code').value="<?php echo  $Accounts_edit['Country_Code']; ?>";
    <?php } ?>
    
    jQuery('#Account-whatsapp-number').on('input', function() {
         var number = jQuery('#Account-whatsapp-number').val();
        if (number.startsWith('0'))
            number = number.substring(1);
            jQuery('#Account-whatsapp-number').val(number)
    });
</script>