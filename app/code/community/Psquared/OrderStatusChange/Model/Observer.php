<?php

class Psquared_OrderStatusChange_Model_Observer
{
	protected $orderState;
	protected $orderStatus;

	public function fetchOrderStatus($observer) {
		// state
		if (!$this->orderState) {
			$this->orderState = $observer->getOrder()->getState();
		}

		// status
		if (!$this->orderStatus) {
			$this->orderStatus = $observer->getOrder()->getStatus();
		}
		return $this;
	}

	public function checkOrderStatus($observer) {
		// state
		if($this->orderState) {
			$previousOrderState = $this->orderState;
		}

		// status
		if(!$this->orderStatus) {
			return;
		} else {
			$previousOrderStatus = $this->orderStatus;
		}

		// status change
		$order = $observer->getOrder();
		$newOrderState = $order->getState();
		$newOrderStatus = $order->getStatus();

		if ($previousOrderStatus != $newOrderStatus) {
			// event data with order and statuses
			$eventData = array(
				'order'                 => $order,
				'previousOrderState'    => $previousOrderState,
				'newOrderState'         => $newOrderState,
				'previousOrderStatus'   => $previousOrderStatus,
				'newOrderStatus'        => $newOrderStatus,
			);

			// specific event, e.g. sales_order_status_change_pending_to_complete
			Mage::dispatchEvent('sales_order_status_change_' . $previousOrderStatus . '_to_' . $newOrderStatus, $eventData);

			// general order change event
			Mage::dispatchEvent('sales_order_status_change', $eventData);
		}
	}
}