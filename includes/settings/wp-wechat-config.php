<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function weixinapp_create_menu() {
    // 创建新的顶级菜单
    add_menu_page('微信小程序设置', '微信小程序设置', 'administrator', 'weixinapp_slug', 'weixinapp_settings_page', plugins_url('rest-api-to-miniprogram/includes/images/icon16.png'),null);
    // 调用注册设置函数
    add_action( 'admin_init', 'register_weixinappsettings' );
}

function get_jquery_source() {
        $url = plugins_url('',__FILE__);        
        wp_enqueue_script("jquery");
        wp_enqueue_style("tabs", plugins_url()."/rest-api-to-miniprogram/includes/js/tab/tabs.css", false, "1.0", "all");
        wp_enqueue_script("tabs", plugins_url()."/rest-api-to-miniprogram/includes/js/tab/tabs.min.js", false, "1.0");
}

function register_weixinappsettings() {
    // 注册设置
    register_setting( 'weixinapp-group', 'wf_appid' );
    register_setting( 'weixinapp-group', 'wf_secret' );
    register_setting( 'weixinapp-group', 'wf_swipe' );
    
    register_setting( 'weixinapp-group', 'wf_mchid' );
    register_setting( 'weixinapp-group', 'wf_paykey' );
    register_setting( 'weixinapp-group', 'wf_paybody' );

    register_setting( 'weixinapp-group', 'wf_poster_imageurl' );
    register_setting( 'weixinapp-group', 'wf_enable_comment_option' );
    register_setting( 'weixinapp-group', 'wf_enable_comment_check' );
    
       
    
    
}

function weixinapp_settings_page() {
?>
<div class="wrap">

<h2>微信小程序设置</h2>


<p>Rest API to miniprogram by <a href="https://www.watch-life.net" target="_blank">守望轩</a>.
<?php

if (!empty($_REQUEST['settings-updated']))
{
    echo '<div id="message" class="updated fade"><p><strong>设置已保存</strong></p></div>';

} 

if (version_compare(PHP_VERSION, '5.6.0', '<=') )
{
    
    echo '<div class="notice notice-error is-dismissible">
    <p><font color="red">提示：php版本小于5.6.0, 插件程序将无法正常使用,当前系统的php版本是:'.PHP_VERSION.'</font></p>
    </div>';

}
?>
<form method="post" action="options.php">
    <div class="responsive-tabs">
    <?php settings_fields( 'weixinapp-group' ); ?>
    <?php do_settings_sections( 'weixinapp-group' ); ?>
    <div class="responsive-tabs">
    <h2> 常规设置</h2>
    <div class="section">
        <table class="form-table">
            <tr valign="top">
            <th scope="row">AppID</th>
            <td><input type="text" name="wf_appid" style="width:400px; height:40px" value="<?php echo esc_attr( get_option('wf_appid') ); ?>" />* </td>
            </tr>
             
            <tr valign="top">
            <th scope="row">AppSecret</th>
            <td><input type="text" name="wf_secret" style="width:400px; height:40px" value="<?php echo esc_attr( get_option('wf_secret') ); ?>" />* </td>
            </tr>

            <tr valign="top">
                            <th scope="row">商户号MCHID</th>
                            <td><input type="text" name="wf_mchid" style="width:400px; height:40px" value="<?php echo esc_attr( get_option('wf_mchid') ); ?>" /> <p style="color: #959595; display:inline">微信支付商户后台获取</p></td>
                        </tr>


                        <tr valign="top">
                            <th scope="row">商户支付密钥key</th>
                            <td><input type="text" name="wf_paykey" style="width:400px; height:40px" value="<?php echo esc_attr( get_option('wf_paykey') ); ?>" /> <p style="color: #959595; display:inline">微信支付商户后台获取</p></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">支付描述</th>
                            <td><input type="text" name="wf_paybody" style="width:400px; height:40px" value="<?php echo esc_attr( get_option('wf_paybody') ); ?>" /><br /><p style="color: #959595; display:inline">* 商家名称-销售商品类目，例如：守望轩-赞赏</p></td>
                        </tr>


            <tr valign="top">
            <th scope="row">小程序首页滑动文章ID</th>
            <td><input type="text" name="wf_swipe" style="width:400px; height:40px" value="<?php echo esc_attr( get_option('wf_swipe') ); ?>" /><p style="color: #959595; display:inline">* 请用英文半角逗号分隔</p></td>
            </tr>

            <tr valign="top">
            <th scope="row">开启小程序的评论</th>
            <td>

                <?php

                $wf_enable_comment_option =get_option('wf_enable_comment_option');            
                $checkbox=empty($wf_enable_comment_option)?'':'checked';
                echo '<input name="wf_enable_comment_option"  type="checkbox"  value="1" '.$checkbox. ' />';
                

                           ?>
                           &emsp;&emsp;&emsp;&emsp;开启评论审核

                <?php
                $wf_enable_comment_check =get_option('wf_enable_comment_check');            
                $checkbox1=empty($wf_enable_comment_check)?'':'checked';
                echo '<input name="wf_enable_comment_check"  type="checkbox"  value="1" '.$checkbox1. ' />';

                ?>
                            </td>
            </tr>     

            <tr valign="top">
            <th scope="row">海报图片默认地址</th>
            <td><input type="text" name="wf_poster_imageurl" style="width:400px; height:40px" value="<?php echo esc_attr( get_option('wf_poster_imageurl') ); ?>" /><br/><p style="color: #959595; display:inline">* 请输完整的图片地址，例如：https://www.watch-life.net/images/poster.jpg</p></td>
            </tr>
                   
        </table>
    </div>

 </div>

    
    <?php submit_button();?>
</form>
 <?php get_jquery_source(); ?>
            <script>
            $(document).ready(function() {
                RESPONSIVEUI.responsiveTabs();
                if($("input[name=post_meta]").attr('checked')) {
                    $("#section_meta_list").addClass("hide");
                }
            });
            </script>
</div>
<?php }  
