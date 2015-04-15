describe('The Ludere Website', function(){
	var siteUrl = "http://192.168.56.101/public/";

	it('should have a <title>', function(){
		browser.get(siteUrl);
		expect(browser.getTitle()).toBeDefined();
	});

	it('should have the following directories', function(){
		browser.get(siteUrl);
		element(by.css('a[ng-href="#/"]')).click();
		element(by.css('a[ng-href="#/list"]')).click();
		element(by.css('a[href="#/signup"]')).click();
		element(by.css('a[ng-click="logAction()"]')).click();

		browser.findElements(by.css('.dropdown-menu li[ng-class] > a')).then(
			function(elements){
				var count = elements.length;

				for(var i = 0; i < count; i++) {
					element(by.css('a[class="dropdown-toggle"]')).click();
					elements[i].click();
					browser.driver.sleep(500);
				}
			}
		);
	});

	it('should login', function(){
		browser.get(siteUrl+"/#/");
		var username = "admin";
		var password = "22840623";

		element(by.css('a[ng-click="logAction()"]')).click();
		element(by.model('usernm')).sendKeys(username);
		element(by.model('passwd')).sendKeys(password);

		element(by.css('input[type="submit"]')).click();

		var profileOptions = element(by.css('a[class="icon dropdown-toggle"]'));
		profileOptions.click();

		browser.driver.sleep(500);
		profileOptions.click();
	});

	it('should go through the tab items for a catalogue item', function(){
		browser.get(siteUrl+"/#/catalogue/all");
		browser.driver.sleep(500);

		element.all(by.repeater('item in catalogue')).count().then(function(count){
			element.all(by.repeater('item in catalogue'))
			.get(Math.floor(Math.random() * count) % 50)
			.element(by.css('a')).click();
		});
		
		browser.waitForAngular();

		element.all(by.css('ul[class="nav nav-pills"] > li > a > a')).then(
			function(elements){
				var count = elements.length;
				for(var i = 0; i < count; i++) {
					elements[i].click();
				}
			}
		);
	});

	it('should make the test wait for 1 seconds', function(){
		browser.driver.sleep(1000);
	});
	
});