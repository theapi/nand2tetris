
load local.asm,
output-file local.out,
compare-to local.cmp,
output-list RAM[300]%D1.6.1 RAM[302]%D1.6.1;


repeat 75 {
  ticktock;
}

output;
