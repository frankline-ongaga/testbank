def is_triangle(a,b,c):
	if a>(b+c) or b>(a+c) or c>(a+b):
		print ('No')
	else:
		print ('Yes')

def enter_inputs():
  a=int(input("Enter the value of  first stick: \n"))
  b=int(input("Enter the value of  second stick: \n"))
  c=int(input("Enter the value of  third stick: \n"))
  is_triangle(a,b,c)

enter_inputs()