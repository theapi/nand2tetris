
load local.asm,
output-file local.out,
compare-to local.cmp,
output-list RAM[300]%D1.6.1 RAM[301]%D1.6.1 RAM[302]%D1.6.1 RAM[256]%D1.6.1;


repeat 85 {
  ticktock;
}

output;
