<script language="javascript" type="text/javascript">
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }
</script>
<?php
echo $view->buttonList()
    ->insert($view->button('Settings', $view::BUTTON_LINK)->setAttribute('value', $view->getModuleUrl('/Bandwidthd/Settings')))
;

echo '<iframe src="'.$view['url'].'" frameborder="0" width="100%" height="100%" style="min-height: 300px" onload="resizeIframe(this)">';
echo '<p>Your browser does not support iframes.</p>';
echo '</iframe>';
