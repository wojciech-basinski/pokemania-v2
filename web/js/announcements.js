function loadAnnouncement(page) {
    page = page - 1;
    $('#content').load(loadHref+'?page='+page);
}