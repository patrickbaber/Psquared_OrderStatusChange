<?php

class Psquared_OrderStatusChange_Model_Observer
{
	const REGISTRY_KEY = 'psquared_order_status';

	protected $orderStatus;

	public function fetchOrderStatus($observer) {
		if (!$this->orderStatus) {
			$this->orderStatus = $observer->getOrder()->getStatus();
		}
		return $this;
	}

	public function checkOrderStatus($observer) {
		Mage::log('checkOrderStatus: ' . $this->orderStatus);
		if(!$this->orderStatus) {
			return;
		} else {
			$previousOrderStatus = $this->orderStatus;
		}

		//status change
		$order = $observer->getOrder();
		$newOrderStatus = $order->getStatus();
		if ($previousOrderStatus != $newOrderStatus) {
			//dispatch specific event, e.g. sales_order_status_change_pending_to_complete
			Mage::dispatchEvent('sales_order_status_change_' . $previousOrderStatus . '_to_' . $newOrderStatus, array('order' => $order));

			//general order change event
			Mage::dispatchEvent('sales_order_status_change', array('order' => $order));
		}
	}
}