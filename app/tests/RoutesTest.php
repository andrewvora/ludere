<?php

class RoutesWorkTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function donttestDefaultRoute()
	{
		$crawler = $this->client->request('GET', '/');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testCatalogueControllerIndexMethod(){
		$crawler = $this->client->request('GET', '/catalogue/all');
		$this->assertTrue($this->client->getResponse()->isOk());
	}
}
