<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductSupplierRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductSupplierCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductSupplierCrudController extends CrudController
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
        CRUD::setModel(\App\Models\ProductSupplier::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product-supplier');
        CRUD::setEntityNameStrings('product supplier', 'product suppliers');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
    // Get all table columns (used by `setFromDb()`)
    $this->crud->setFromDb();

    // Override the columns for product_id and supplier_id to display names
    $this->crud->setColumns([
        [
            'label' => 'Mặt hàng', // Column heading
            'type' => 'select',
            'name' => 'product_id', // the column that contains the ID of the related entity
            'entity' => 'product', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => \App\Models\Product::class, // optional
        ],
        [
            'label' => 'Nhà cung cấp',
            'type' => 'select',
            'name' => 'supplier_id',
            'entity' => 'supplier',
            'attribute' => 'name',
            'model' => \App\Models\Supplier::class, // optional
        ],
        // Add other columns as needed, or let setFromDb handle them
        'supplier_product_code',
        'cost_price',
    ]);






    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductSupplierRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        CRUD::field([
        'type'      => 'select',
        'name'      => 'product_id',
        'model'     => \App\Models\Product::class,
        'attribute' => 'name',
        ]);
        CRUD::field([  
        'type'      => 'select',
        'name'      => 'supplier_id',
        'model'     => \App\Models\Supplier::class,
        'attribute' => 'name',
        ]);
        CRUD::field('supplier_product_code')->type('text')->size(12)->allowNull(true);
        CRUD::field('cost_price')->type('number')->size(15,2);

        
 

        CRUD::field('product_id')->validationRules('required|min:1');
        CRUD::field('supplier_id')->validationRules('required|min:1');
        CRUD::field('cost_price')->validationRules('required|min:3');


        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */


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
