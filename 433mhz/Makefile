all:codesend

codesend: RCSwitch.o codesend.o
		$(CXX) $(CXXFLAGS) $(LDFLAGS) $+ -o $@ -lwiringPi
