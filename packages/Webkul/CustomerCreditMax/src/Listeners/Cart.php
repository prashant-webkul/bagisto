<?php

namespace Webkul\CustomerCreditMax\Listeners;

use Illuminate\Support\Facades\Mail;
use Webkul\Sales\Repositories\OrderRepository;
use Cart as CartFacade;
use Webkul\CustomerCreditMax\Repositories\CustomerCreditMaxRepository as CreditMax;

/**
 * Cart event handler
 *
 * @author  Webkul <support@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class Cart
{
    /**
     * OrderRepository object
     *
     * @var Product
    */
    protected $orderRepository;

    /**
     * CustomerCreditMaxRepository Repository
     */
    protected $creditMax;

    /**
     * Create a new cart event listener instance.
     *
     * @param  Webkul\Sales\Repositories\OrderRepository $orderRepository
     * @return void
     */
    public function __construct(OrderRepository $orderRepository, CreditMax $creditMax)
    {
        $this->creditMax = $creditMax;

        $this->orderRepository = $orderRepository;
    }

    /**
     * Return current logged in customer
     *
     * @return Customer | Boolean
     */
    public function getCurrentCustomerGuard()
    {
        $guard = request()->has('token') ? 'api' : 'customer';

        return auth()->guard($guard);
    }

    /**
     * Checks if customer credit amount exceeded or not
     *
     * @param mixed $cartItem
     */
    public function cartItemAddBefore($productId)
    {
        if (! core()->getConfigData('customer.settings.credit_max.status') || ! $this->getCurrentCustomerGuard()->check())
            return;

        $limit = $this->creditMax->findOneWhere([
            'customer_id' => auth()->guard('customer')->user()->id
        ])->limit;

        $baseGrandTotal = $this->orderRepository->scopeQuery(function ($query) {
            return $query
                ->where('orders.customer_id', $this->getCurrentCustomerGuard()->user()->id)
                ->where('orders.status', '<>', 'canceled');
        })->sum('base_grand_total');

        $baseGrandTotalInvoiced = $this->orderRepository->scopeQuery(function ($query) {
            return $query
                ->where('orders.customer_id', $this->getCurrentCustomerGuard()->user()->id)
                ->where('orders.status', '<>', 'canceled');
        })->sum('base_grand_total_invoiced');

        if ( ($baseGrandTotal - $baseGrandTotalInvoiced) >= core()->getConfigData('customer.settings.credit_max.amount'))
            throw new \Exception(trans('customercreditmax::app.admin.system.limit-exceeded'));
    }
}