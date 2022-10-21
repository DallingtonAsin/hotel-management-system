@extends('errors::illustrated-layout')

@section('title', $title ?? $message)

@section("code", 200)

@section('message', $message ?? $title)
