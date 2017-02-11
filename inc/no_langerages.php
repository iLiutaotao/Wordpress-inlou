<?php
/* 禁止全英日俄韩阿泰语评论 */
function ssdax_comment_all_post( $incoming_comment ) {  
$enpattern = '/[一-龥]/u';  
$jpattern ='/[ぁ-ん]+|[ァ-ヴ]+/u';  
$ruattern ='/[А-я]+/u';  
$krattern ='/[갂-줎]+|[줐-쥯]+|[쥱-짛]+|[짞-쪧]+|[쪨-쬊]+|[쬋-쭬]+|[쵡-힝]+/u';  
$arattern ='/[؟-ض]+|[ط-ل]+|[م-م]+/u';  
$thattern ='/[ก-๛]+/u';  
if(!preg_match($enpattern, $incoming_comment['comment_content'])) {  
wp_die( "写点汉字吧，博主外语很捉急！ Please write some chinese words！" );  
}  
if(preg_match($jpattern, $incoming_comment['comment_content'])){  
wp_die( "日文滚粗！Japanese Get out！日本語出て行け！" );  
}  
if(preg_match($ruattern, $incoming_comment['comment_content'])){  
wp_die( "北方野人讲的话我们不欢迎！Russians, get away！Savage выйти из Русского Севера!" );  
}  
if(preg_match($krattern, $incoming_comment['comment_content'])){  
wp_die( "思密达的世界你永远不懂！Please do not use Korean！하시기 바랍니다 한국 / 한국어 사용하지 마십시오！" );  
}  
if(preg_match($arattern, $incoming_comment['comment_content'])){  
wp_die( "禁止使用阿拉伯语！Please do not use Arabic！！من فضلك لا تستخدم اللغة العربية" );  
}  
if(preg_match($thattern, $incoming_comment['comment_content'])){  
wp_die( "人妖你好，人妖再见！Please do not use Thai！กรุณาอย่าใช้ภาษาไทย！" );  
}  
return( $incoming_comment );  
}  
add_filter('preprocess_comment', 'ssdax_comment_all_post'); 
?>