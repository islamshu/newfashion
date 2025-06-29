@extends('layouts.master')
@section('title', __('Translate file') . ' ' . __($language))
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('Translate file') }} {{ __($language) }}</h3>

                </div>

            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->

                <!-- Row created callback -->
                <!-- File export table -->

                <section id="file-export">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        {{ __('Translate file') }} {{ __($language) }}
                                        <form class="form-horizontal" action="{{ route('languages.key_value_store') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $language }}">

                                            <table class="table ">
                                                <thead>
                                                    <tr>
                                                        <th width="20">#</th>
                                                        <th width="40">{{ __('Key') }}</th>
                                                        <th width="40">{{ __('Value') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach (openJSONFile('ar') as $key => $value)
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td class="key">{{ $key }}</td>
                                                            <td>
                                                                <input type="text" class="form-control value"
                                                                    style="width:100%" name="key[{{ $key }}]"
                                                                    @isset(openJSONFile($language)[$key])
                                            value="{{ openJSONFile($language)[$key] }}"
                                        @endisset>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                </tbody>

                                            </table>
                                            <div class="panel-footer text-right">
                                                <button type="button" class="btn btn-warning"
                                                    onclick="copyTranslation()">{{ __('Copy Translations') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- File export table -->
            </div>
        </div>
    </div>
@endsection
