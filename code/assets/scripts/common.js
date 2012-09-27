function popupContentForm(url, page, token, language, mode) {
	url = url + '&fuseactionid=' + page + '&token=' + token + '&languageid=' + language + '&formdisplaymode=' + mode;
	newwindow = window.open(url,'name','height=570,width=650');
	if (window.focus) {newwindow.focus()}
	return false;
}