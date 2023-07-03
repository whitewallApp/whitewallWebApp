<script async src="https://js.stripe.com/v3/pricing-table.js"></script>
<stripe-pricing-table pricing-table-id="<?= getenv("STRIPE_PRICING_TABLE") ?>" publishable-key="<?= getenv("STRIPE_PUBLIC_KEY") ?>" client-reference-id="<?= $accountID ?>">
</stripe-pricing-table>