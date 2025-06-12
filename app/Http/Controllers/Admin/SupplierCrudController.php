<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SupplierRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SupplierCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SupplierCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Supplier::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/supplier');
        CRUD::setEntityNameStrings('supplier', 'Danh sách nhà cung cấp');


        if(!backpack_user()->can('Quản lý nhà cung cấp')){
	    // deny access to operations
            CRUD::denyAccess(['list','show','create','update','delete']);
        }

    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SupplierRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */

        CRUD::field([
            'label' => 'Tên nhà cung cấp',
            'type'      => 'text',
            'name'      => 'name',
            'attribute' => 'name',
        ])->validationRules('required|min:1');

        CRUD::field([
            'label' => 'Địa chỉ',
            'type'      => 'text',
            'name'      => 'address',
            'attribute' => 'address',
        ])->validationRules('nullable');
        CRUD::field([
            'label' => 'Số điện thoại',
            'type'      => 'text',
            'name'      => 'phone',
            'attribute' => 'phone',
        ])->validationRules('nullable');
        CRUD::field([
            'label' => 'Người liên hệ',
            'type'      => 'text',
            'name'      => 'contact_person',
            'attribute' => 'contact_person',
        ])->validationRules('nullable|email');
        CRUD::field([
            'label' => 'Email',
            'type'      => 'email',
            'name'      => 'email',
            'attribute' => 'email',
        ])->validationRules('nullable|email');
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
