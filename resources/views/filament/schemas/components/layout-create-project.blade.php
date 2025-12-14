<div class="grid grid-flow-col grid-row-6 gap-6">
    <div class="col-span-6 row-span-2 content-center">
        {{ $getChildSchema()->getComponent('name') }}
    </div>
    <div class="col-span-6 row-span-2 content-center">
        {{ $getChildSchema()->getComponent('company_name') }}
    </div>
    <div class="col-span-6 row-span-2 content-center">
        {{ $getChildSchema()->getComponent('company_email') }}
    </div>
    <div class="row-span-6 content-center justijy-center">
        {{ $getChildSchema()->getComponent('image') }}
    </div>
</div>