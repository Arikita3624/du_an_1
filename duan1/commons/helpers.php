<?php

function getStatusText($status)
{
    switch ($status) {
        case 'pending':
            return 'Chờ xử lý';
        case 'processing':
            return 'Đang xử lý';
        case 'confirmed':
            return 'Đã xác nhận';
        case 'delivering':
            return 'Đang giao hàng';
        case 'completed':
            return 'Đã giao hàng';
        case 'finished':
            return 'Hoàn thành';
        case 'cancelled':
            return 'Đã hủy';
        default:
            return 'Không xác định';
    }
}

function getStatusBadgeClass($status)
{
    switch ($status) {
        case 'pending':
            return 'secondary'; // màu xám cho Chờ thanh toán
        case 'processing':
            return 'warning';   // màu vàng cho Đang xử lý
        case 'delivering':
            return 'info';
        case 'confirmed':
            return 'success';
        case 'completed':
            return 'success';
        case 'finished':
            return 'success';
        case 'cancelled':
            return 'danger';
        default:
            return 'secondary';
    }
}

function getPaymentMethodText($method)
{
    switch ($method) {
        case 'cod':
            return 'Thanh toán khi nhận hàng';
        case 'banking':
            return 'Chuyển khoản ngân hàng';
        case 'momo':
            return 'Ví MoMo';
        case 'zalopay':
            return 'Ví ZaloPay';
        default:
            return 'Không xác định';
    }
}

function getPaymentStatusText($status)
{
    switch ($status) {
        case 'pending':
            return 'Chờ thanh toán';
        case 'paid':
            return 'Đã thanh toán';
        case 'failed':
            return 'Thanh toán thất bại';
        default:
            return 'Không xác định';
    }
}

function getPaymentStatusBadgeClass($status)
{
    switch ($status) {
        case 'pending':
            return 'secondary'; // màu xám cho Chờ thanh toán
        case 'paid':
            return 'success';
        case 'failed':
            return 'danger';
        default:
            return 'secondary';
    }
}
