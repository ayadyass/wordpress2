<div id="footer">
<div class="lt"><?php _e('Copyright &copy; 2010 ','nattywp'); ?><?php _e('All rights reserved.','nattywp'); ?></div>
<div class="rt">Designed by <a href="http://www.nattywp.com" title="wordpress themes"><img src="<?php echo get_template_directory_uri(); ?>/images/natty-logo.png" width="82" height="17" valign="3px" class="png" alt="wordpress themes" align="middle" /></a></div>		
<div class="clear"></div>			
</div>
    </div> <!-- END Columns --> 
    
   
</div><!-- END main -->
</div>  
<div class="clear"></div>

<?php $t_tracking = t_get_option( "t_tracking" );
if ($t_tracking != ""){
	echo stripslashes(stripslashes($t_tracking));
	}
?>

<?php wp_footer(); ?>       
</body>
</html>