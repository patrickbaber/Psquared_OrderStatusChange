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
			$oldOrderState = $this->orderState;
		}

		// status
		if(!$this->orderStatus) {
			return;
		} else {
			$oldOrderStatus = $this->orderStatus;
		}

		// status change
		$order              = $observer->getOrder();
		$newOrderState      = $order->getState();
		$newOrderStatus     = $order->getStatus();

		if ($oldOrderStatus != $newOrderStatus) {
			// event data with order and statuses
			$eventData = array(
				'order'             => $order,
				'old_order_state'   => $oldOrderState,
				'new_order_state'   => $newOrderState,
				'old_order_status'  => $oldOrderStatus,
				'new_order_status'  => $newOrderStatus,
			);

			// specific event, e.g. sales_order_status_change_pending_to_complete
			Mage::dispatchEvent('sales_order_status_change_' . $oldOrderStatus . '_to_' . $newOrderStatus, $eventData);

			// general order change event
			Mage::dispatchEvent('sales_order_status_change', $eventData);
		}
	}
}