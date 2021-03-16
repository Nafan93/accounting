@extends('layouts.app')

@section('content')  


<div class="uk-container uk-padding">
    <div aria-label="breadcrumb">
        <ul class="uk-breadcrumb">
            <li><a href="#">/</a></li>
            <li><a href="{{ route('invoices.index') }}">Счета</a></li>
            <li><span>Создать счет</span></li>
        </ul>
    </div>
    <!-- /.breadcrumb -->
    <h2>Новый счет</h2>
    @if ($errors->any())
        <div class="uk-alert-danger uk-width-1-2" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <ul class="uk-list">    
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="uk-card">
        <div class="uk-card-body">
            <div class="uk-flex uk-flex-center">
        
                <form method="post" action="{{ route('invoices.store') }}" class="uk-width-1-2">
                    @csrf
                    <div class="uk-margin">
                        <div class="uk-flex uk-flex-middle uk-flex-between">
                            <span>Счет № </span>
                            <input type="text" class="uk-input uk-form-width-small" value="" placeholder="Номер">
                            <span> от </span>
                            <input type="date" id="start" name="trip-start"
                                value="{{ date("Y-m-d") }}"
                                min="2020-01-01" max="2051-12-31"
                                class="uk-input uk-form-width-medium" >
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="uk-flex uk-flex-middle uk-flex-between">
                            <span>Расчетный счет:</span>
                            <select class="uk-select" name="rs" id="rs">
                                @forelse ($companies as $company)
                                    <option value="{{ $company->rs }}">{{ $company->rs }}</option>
                                @empty
                                    <option value="">Нет расчетного счета</option>
                                @endforelse
                            </select>
                        </div>
                        <!-- /.uk-flex uk-flex-middle uk-flex-between -->
                    </div>
                    <!-- /.uk-margin -->
                    <div class="uk-margin">
                        <div class="uk-flex uk-flex-middle uk-flex-between">
                            <span>Покупатель:</span>
                            <select class="uk-select" name="rs" id="rs">
                                @forelse ($customers as $customer)
                                    <option value="{{ $customer->name }}">{{ $customer->name }}</option>
                                @empty
                                    <option value="">Нет покупателей</option>
                                @endforelse
                            </select>
                            <a href="{{ route('customers.create') }}" class="uk-button uk-button-primary">Добавить</a>
                        </div>
                        <!-- /.uk-flex uk-flex-middle uk-flex-between -->
                    </div>
                    <!-- /.uk-margin -->
                    <div class="uk-margin">
                        <button type="submit" class="uk-button uk-button-primary">Добавить</button>
                    </div>
                </form>
    
            </div>
            <!-- /.uk-flex -->
        </div>
        <!-- /.uk-card-body -->
    </div>
    <!-- /.uk-card -->
</div>
<!-- /.uk-container -->    

@endsection
