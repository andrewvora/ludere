describe('The SeenByMe Website', function(){
	var siteUrl = "http://192.168.56.101/public/";

	it('should have a <title>', function(){
		browser.get(siteUrl);
		expect(browser.getTitle()).toBeDefined();
	});

	it('should have a ', function(){
		browser.get(siteUrl);
		element(by.css('a[ng-href="#/"]')).click();
		element(by.css('a[ng-href="#/list"]')).click();
		element(by.css('a[href="#/signup"]')).click();
		element(by.css('a[href="#/login"]')).click();

		browser.findElements(by.css('.dropdown-menu li[ng-class] > a')).then(
			function(elements){
				var count = elements.length;

				for(var i = 0; i < count; i++) {
					element(by.css('a[class="dropdown-toggle"]')).click();
					elements[i].click();
				}
			}
		);
	});

});