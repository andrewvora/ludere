<?php

class RoutesWorkTest extends TestCase {
	/* Data Providers
	 *-------------------------------*/
	public function providerTestCatalogueTypes(){
		return array(
				array('all'),
				array('movies'),
				array('series'),
				array('web'),
				array('people'),
				array('users'),
				array('companies')
			);
	}

	/* Tests
	 *-------------------------------*/

	/**
	 * A basic functional test example.
	 */
	public function testDefaultRoute()
	{
		$crawler = $this->client->request('GET', '/');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	/**
	 * @dataProvider providerTestCatalogueTypes
	 */
	public function testCatalogueControllerIndexMethod($type){
		$crawler = $this->client->request('GET', "/catalogue/$type");
		$this->assertTrue($this->client->getResponse()->isOk());
	}

}
