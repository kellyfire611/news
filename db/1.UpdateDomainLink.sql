UPDATE wp_posts 
	SET post_content = REPLACE(post_content, 'http://localhost/news', 'http://news.aigiupminhkhong.vn')
	 	 , guid = REPLACE(guid, 'http://localhost/news', 'http://news.aigiupminhkhong.vn');
UPDATE wp_options 
	SET option_value = REPLACE(option_value, 'http://localhost/news', 'http://news.aigiupminhkhong.vn');