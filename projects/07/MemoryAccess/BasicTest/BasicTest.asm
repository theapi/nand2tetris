// init SP pointing to 256
@256
D=A
@SP
M=D

// init LCL pointing to 300
@300
D=A
@LCL
M=D

// init ARG pointing to 400
@400
D=A
@ARG
M=D

// init THIS pointing to 3000
@3000
D=A
@THIS
M=D

// init THAT pointing to 3010
@3010
D=A
@THAT
M=D

// constant
@10
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// local
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store popped value in D
@LCL   // set address to LCL
A=M   // use the value stored in LCL as the next address
M=D   // store the value at the address

// constant
@21
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// constant
@22
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// argument
@2
D=A    // Store the index value in D
@ARG   // set address to ARG
D=D+M  // store the address stored in ARG + index in D
@R13  // temp store the address
M=D   // store the address in R13
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store the value in D
@R13  // R13 address
A=M   // use the value stored in R13 as the next address
M=D   // store the value at the address

// argument
@1
D=A    // Store the index value in D
@ARG   // set address to ARG
D=D+M  // store the address stored in ARG + index in D
@R13  // temp store the address
M=D   // store the address in R13
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store the value in D
@R13  // R13 address
A=M   // use the value stored in R13 as the next address
M=D   // store the value at the address

// constant
@36
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// this
@6
D=A    // Store the index value in D
@THIS   // set address to THIS
D=D+M  // store the address stored in THIS + index in D
@R13  // temp store the address
M=D   // store the address in R13
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store the value in D
@R13  // R13 address
A=M   // use the value stored in R13 as the next address
M=D   // store the value at the address

// constant
@42
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// constant
@45
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// that
@5
D=A    // Store the index value in D
@THAT   // set address to THAT
D=D+M  // store the address stored in THAT + index in D
@R13  // temp store the address
M=D   // store the address in R13
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store the value in D
@R13  // R13 address
A=M   // use the value stored in R13 as the next address
M=D   // store the value at the address

// that
@2
D=A    // Store the index value in D
@THAT   // set address to THAT
D=D+M  // store the address stored in THAT + index in D
@R13  // temp store the address
M=D   // store the address in R13
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store the value in D
@R13  // R13 address
A=M   // use the value stored in R13 as the next address
M=D   // store the value at the address

// constant
@510
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// segment direct
@6
D=A    // Store the index value in D
@R5   // set address to R5
D=D+A  // store the address of R5 + index in D
@R13  // temp store the address
M=D   // store the address in R13
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store the value in D
@R13  // R13 address
A=M   // use the value stored in R13 as the next address
M=D   // store the value at the address
// local
@0
D=A       // Store the index value in D
@LCL   // set address to LCL
A=D+M     // set the address to be LCL + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// that
@5
D=A       // Store the index value in D
@THAT   // set address to THAT
A=D+M     // set the address to be THAT + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

//    add
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M    // the last entered value
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=D+M  // x+y
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// argument
@1
D=A       // Store the index value in D
@ARG   // set address to ARG
A=D+M     // set the address to be ARG + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

//    sub
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M    // the last entered value
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M-D  // x-y
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// this
@6
D=A       // Store the index value in D
@THIS   // set address to THIS
A=D+M     // set the address to be THIS + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// this
@6
D=A       // Store the index value in D
@THIS   // set address to THIS
A=D+M     // set the address to be THIS + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

//    add
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M    // the last entered value
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=D+M  // x+y
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

//    sub
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M    // the last entered value
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M-D  // x-y
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// segment direct
@6
D=A       // Store the index value in D
@R5   // set address to R5
A=D+A     // set the address to be address of R5 + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

//    add
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M    // the last entered value
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=D+M  // x+y
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

