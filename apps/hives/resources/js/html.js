;var html = {
	
	'timelineform' : function(data)
		{
			var thtml = [];
			
			thtml.push("<h3>Share anything to Hives or Friends</h3>");
			thtml.push("<p>Share audio, video, places and events to your friends or groups securely. No one will see your post other than the people you specified.</p>");
			thtml.push("<div class=\"timeline_form\">");
			thtml.push("<div class=\"form_tab\">");
			thtml.push("	<a href=\"#\" class=\"active newstatus\" data-ttype=\"status\"></a>");
			thtml.push("	<a href=\"#\" class=\"photo\" data-ttype=\"photo\"></a>");
			thtml.push("	<a href=\"#\" class=\"video\" data-ttype=\"video\"></a>");
			thtml.push("	<a href=\"#\" class=\"file\" data-ttype=\"file\"></a>");
			thtml.push("	<a href=\"#\" class=\"music\" data-ttype=\"music\"></a>");
			thtml.push("	<a href=\"#\" class=\"internet\" data-ttype=\"internet\"></a>");
			thtml.push("	<a href=\"#\" class=\"places\" data-ttype=\"places\"></a>");
			thtml.push("	<a href=\"#\" class=\"event\" data-ttype=\"event\"></a>");
			thtml.push("</div>");
			
			thtml.push("<div class=\"tpane post tactive\">");
			thtml.push("	<form method=\"post\" action=\"\" class=\"timeline_frm\">");
			thtml.push("	<input type=\"hidden\" name=\"type\" value=\"status\"/>");
			thtml.push("		<div id=\"load_form\">");
			
		
			thtml.push("		</div>");
			thtml.push("		<div class=\"spacer5\"></div>");
			thtml.push("		<div class=\"tp_label\"><span class=\"t_icon ico-add\"></span>Share this post to</div>");
			thtml.push("		<input type=\"text\" class=\"t_input reset\" placeholder=\"Type of your friends name or Hives here...\"/>");
					
			thtml.push("		<div class=\"tp_label\"><span class=\"t_icon ico-email\"></span>Share this post to</div>");
			thtml.push("		<input type=\"text\" class=\"t_input reset\" name=\"f_email\" placeholder=\"Enter your friend's email address\"/>");
					
			thtml.push("		<div class=\"btn_action_right\">");
			thtml.push("		<button class=\"hbtn\" type=\"button\" onclick=\"$('#timelinePost').modal('hide');\">Discard</button>");
			thtml.push("		<button class=\"hbtn\" type=\"button\">Save Draft</button>");
			thtml.push("		<button class=\"hbtn\" type=\"submit\">Share</button>");
			thtml.push("		</div>");
			thtml.push("	</form>");
			thtml.push("</div>");

			
			
			$('.modal_timeline_body').empty().prepend(thtml.join(""));
		}
		
	,'tform': function(type)
		{
			thtml = [];
			
			if(type == "video" || type == "photo")
			{
				var title = type;
				
				thtml.push("<div class=\"text\">");
				thtml.push("<div class=\"share_gray_content\">");
				thtml.push("	<h4 class=\"t_h4\">Share "+title+" to your friends</h4>");
				thtml.push("	<button type=\"button\" class=\"btnblue\">Browser Photo</button>");
				thtml.push("	<span class=\"t_info\">");
				thtml.push("		<p>Select  "+title+" file on your computer.</p>");
				thtml.push("		<p>Refrain from sharing porn or offensive video.</p>");
				thtml.push("	</span>");
				thtml.push("</div>");
				thtml.push("</div>");
				thtml.push("<div class=\"spacer5\"></div>")
				thtml.push("<div class=\"text text2\"><textarea class=\"reset\" name=\"status\" placeholder=\"Got something to say?\"></textarea></div>");
			}
			
			if(type == "status")
			{
				thtml.push("			<textarea class=\"reset\" name=\"status\" placeholder=\"Got something to say?\"></textarea>");
			}	
			
			$('#load_form').empty().prepend(thtml.join(""));
		}
};
