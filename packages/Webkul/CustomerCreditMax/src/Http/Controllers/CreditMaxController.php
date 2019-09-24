<?php

namespace Webkul\CustomerCreditMax\Http\Controllers;

use Webkul\CustomerCreditMax\Repositories\CustomerCreditMaxRepository as CreditMax;

/**
 * CreditMax Controller
 *
 * @author Webkul <support@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class CreditMaxController extends Controller
{
    /**
     * CustomerCreditMax Repository
     */
    protected $creditMax;

    public function __construct(CreditMax $creditMax)
    {
        $this->creditMax = $creditMax;
    }

    /**
     * To sync credit max value (increase / decrease or reset)
     */
    public function syncCreditMax($id)
    {
        $customerCreditMax = $this->creditMax->findOneWhere([
            'customer_id' => $id
        ]);

        $updated = $created = null;

        if ($customerCreditMax) {
            $updated = $customerCreditMax->update([
                'limit' => request()->input('limit')
            ]);
        } else {
            $this->creditMax->Create([
                'customer_id' => $id,
                'limit' => request()->input('limit'),
                'company_id' => \Company::getCurrent()->id
            ]);
        }

        if ($updated || $created) {
            session()->flash('success', 'Credit max value had been synced');
        } else {
            session()->flash('success', 'Credit max value cannot be synced');
        }

        return redirect()->back();
    }
}