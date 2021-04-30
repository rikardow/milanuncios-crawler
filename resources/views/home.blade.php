@extends('layouts.app')

@section('content')
<v-row>
    <v-col cols="12">
        <filter-form :categories="{{ $categories }}">

        </filter-form>
    </v-col>
</v-row>

<v-row>
    @foreach($recentAds as $ad)
    <v-col cols="12" md="6" lg="4">
        <ad-card :ad="{{ $ad }}">

        </ad-card>
    </v-col>
    @endforeach
</v-row>

@endsection
